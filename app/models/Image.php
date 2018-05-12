<?php
namespace App\Models;


class Image {

    protected $message; // messaggio di errore
    protected $fileName; // nome del file caricato
    protected $fileType; // il tipo/estensione del file
    protected $fileTmpName; // posizione temporanea del file quando viene caricato
    protected $fileExtension; // estensione del file es. jpg, jpeg, png, gif, etc.. che otteniamo noi per sicurezza
    protected $fileNewName; // rinominiamo il file in un formato più adatto  per essere memorizzato nel database
    protected $img_resource; // è una risorsa/copia del file originale sul quale andremo a fare le modifiche e salvarlo
    protected $img_width; // larghezza del' immagine
    protected $img_height; // laltezza del' immagine
    protected $max_width; // massima larghezza del file da noi accettato
    protected $max_height;  // massima altezza del file da noi accettato
    protected $folder; // 'public/img/posts/'; // percorso del file dove andremo a salvarlo


public function __construct(int $max_width, int $max_height, int $max_size, string $folder, array $data ){

   // echo '<pre>', print_r($data) ,'</pre>';
 
    if ( !$data['file']['error']  ||  is_uploaded_file($data['file']['tmp_name'])    )  {// { exit;} // file non caricato
   
        //$this->message  = empty($data) ? 'Nessun file caricato': '';
        //$this->message .= !isset($data['file']) ? 'Non hai inviato nessun file': '';
        //$this->message .= !is_uploaded_file($data['file']['tmp_name']) ? 'Possibile file upload attack': '';
        //$this->message .=  $data['file']['error']  ? 'Si è verificato un errore nel caricamento del file': '';
        $this->message =  $data['file']['size'] > $max_size ? "Il file caricato supera il limite di ".$max_size." bytes": '';

        $this->fileName = $data['file']['name'];
        $this->fileType = $data['file']['type'];
        $this->fileTmpName = $data['file']['tmp_name'];

        $this->max_width = $max_width;
        $this->max_height = $max_height;
        $this->folder = "public/img/$folder/"; 

        $this->fileExtension = $this->getExtension(); // +m
    
        if ( empty($this->getMessage()) ) {
        $this->setNewImageName();
        $this->resource(); // +m
        $this->rotate();
        $this->scale();
        $this->save(); // +m
        }

    } 
 }

 public function getMessage(){
  
        return $this->message;
    
 }


  
/*******************************************************************************************************************************|
* GET-NEW-IMAGE-NAME                                                                                                            |
* rinominiamo il file con un id univoco + l'estensione del file                                                                 |
* sul database alla colonna dove salveremo il nome dell' immagine per sicurezza impostare à VARCHAR 32                          |
* e non meno di 32 perchè la lunghezza della stringa data dalla funzione uniqid più l'estensione può arrivare a 32 caratteri    |
* es.  5af08b6fe70335.78055591.tiff_ii  {= 32 caratteri}                                                                        |                          
********************************************************************************************************************************/  
public function setNewImageName() {

    $this->fileNewName = uniqid('', true).'.'.$this->fileExtension;  
}


public function getNewImageName() {

    return $this->fileNewName;
}


/***********************************************************************************************************************************|
* GET-EXTENSION                                                                                                                     |
* Inizializziamo un array con i tipi di estensioni che accettiamo per i file da caricare es. array('jpg', 'jpeg', 'png')            |
* Con la funzione 'explode' spezziamo il nome del file che abbiamo caricato dove ci sono i punti '.'                                |
* es. se il file si chiama 'foto.gatto.jpg' verrà creato un array ['foto', 'gatto', 'jpg']                                          |
* a noi serve l'ultimo indice che contiene l'estensione del file scritto in minuscolo                                               |
* per fare questo utilizziamo la funzione 'end' che prende il valore dell'ultimo indice                                             |
* e lo trasformiamo in minuscolo con la funzione 'strtolower' perchè l'estensione potrebbe anche essere in maiuscolo                |
* Con la funzione 'in_array' controlliamo se l'estensione che abbiamo ottenuto combacia                                             |
* con le estensioni nell'array da noi accettate                                                                                     |
* Se non combacia allora l'utente riceverà un messaggio di errore che lo avvisa che il tipo di file da lui caricato non è accettato |
* Se combacia allora ritorniamo il nome dell'estensione del file.                                                                   |
************************************************************************************************************************************/   
public function getExtension(){
                   
    // CONTROLLA L ESTENSIONE DEL FILE
    $ext_ok = array('jpg', 'jpeg', 'png'); // creiamo un array con i tipi di file
    $temp = explode('.', $this->fileName); // dividiamo il nome del file dove c'è il punto [ immagine.jpg = 'immagine' e 'jpg' ]  
    $extension = strtolower(end($temp)); // ritorna la parte finale del nome spezzato es. 'jpg' in minuscolo 
    if (!in_array($extension, $ext_ok))   {   // se non c'è il la parola 'jpg' nell'array ('doc', 'docx', 'pdf') 
        $this->message .= "I file con l' estensione ".$this->fileType." non sono ammessi!";
       
    } else {
        return $extension;
    }

}

            
                                   
/***************************************************************************************************************************|
* RESOURCE                                                                                                                  |
* La funzione 'getimagesize' chiede come argomento il percorso temporaneo del file ($this->fileTmpName)                     | 
* Ritorna un array che contiene [larghezza-del-file, altezza-del-file, estensione-del-file]                                 |
* La terza chiave(estensione-del-file) è un numero e a ogni numero corrisponde un tipo di estensione es.:                   |
* 0='UNKNOWN', 1='GIF', 2='JPEG', 3='PNG', 4='SWF', 5='PSD', 6='BMP', 7='TIFF_II', 8='TIFF_MM', 9='JPC',                    |
* 10='JP2', 11='JPX', 12='JB2', 13='SWC', 14='IFF', 15='WBMP', 16='XBM', 17='ICO', 18='COUNT'                               |
*                                                                                                                           |
* Con la funzione imagecreatefromjpeg creiamo una nuova immagine dal file che abbiamo caricato (file or URL)                |
* Ritorna una risorsa di immagine su cui andremo a fare tutte le modifiche(rotate e scale) prima di salvarlo nella cartella |
* Come argomento gli dobbiamo passare il percorso temporaneo del file ($this->fileTmpName)                                  |
****************************************************************************************************************************/   
public function resource(){                        

    list($this->img_width, $this->img_height, $image_type) = getimagesize($this->fileTmpName); 
   
    switch ($image_type){
        case 2: $this->img_resource = imagecreatefromjpeg($this->fileTmpName); break;  
        case 3: $this->img_resource = imagecreatefrompng($this->fileTmpName);  break;  
        default: $this->message .='Il formato file '.$image_type.' non è supportato';
    }
    return $this->img_resource;
}
       

                                   
/***************************************************************************************************************************|
* ROTATE                                                                                                                    |
* Correggiamo l' angolo di rotazione dell' immagine                                                                         |                                                                                               |
* Prima controlliamo se il nostro server provider ha attivato l'estensione EXIF per ottenere i dati sull'immagine           |
* poi prendiamo e controlliamo il valore della chiave 'Orientation'. Se è diverso da 1 allora l'immagine è ruotata.         |
* tramite la funzione 'imagerotate' ruotiamo l'immagine alla sua angolazione normale                                        |
****************************************************************************************************************************/   
public function rotate(){                                            
   
    if (function_exists('exif_read_data')) {
        $exif = @exif_read_data($this->fileTmpName);
        if($exif && isset($exif['Orientation'])) // se ci sono informazioni sull orientamento dell'immagine
        {
            if($exif['Orientation'] != 1){ // se è diverso da 1 vuol dire che l'immagine è ruotata
                $deg = 0;
                switch ($orientation) {
                    case 3: $deg = 180; break;
                    case 6: $deg = 270; break;
                    case 8: $deg = 90;  break;  
                }
                if ( $deg ) { // se diverso da zero
                    $this->img_resource = imagerotate($this->img_resource, $deg, 0);  // ruota l immagine    
                }
            } 
        }
    }
}  
           



public function scale(){                                       
    // RIDIMENSIONARE L IMMAGINE
    $img_ratio = $this->img_width/$this->img_height; // rapporto originale dell immagine | es se 960*640 ratio: 1,5
    $standard_ratio = $this->max_width/$this->max_height; // rapporto standard dell immagine es. 800 x 600 ratio: 1.33

    if ( $standard_ratio > $img_ratio) { // si verifica quando MAX_FILE_HEIGHT è minore dell'altezza del file caricato
        $this->max_width = $this->max_width * $img_ratio;
    } 
    else {
        $this->max_height = $this->max_width / $img_ratio; //  600 / 1,5 = 400
    }
    $this->img_resource = imagescale($this->img_resource,  $this->max_width, $this->max_height); // ridimensiona la risorsa dell immagine
}    




/***************************************************************************************************************************************|
* SAVE                                                                                                                                  |
* Non salva nel database! ma in una cartella                                                                                            |
* Dopo aver apportato tutte le modifiche necessarie alla risorsa dell'immagine, possiamo salvarla col nuovo nome che gli abbiamo dato.  |                                                                                             
* Facciamo uno switch per chiamare la funzione adeguata al tipo di estensione del file caricato.                                        |
* imagejpeg e imagepng creano un immagine in base alla risorsa dell'immagine e la posizionano nella path della directory da noi scelta  |
* come secondo parametro delle funzioni possiamo scegliere la qualità del file che va da 0(bassa) a 100(alta).                          |          
****************************************************************************************************************************************/   
public function save(){     
  
    switch ($this->fileExtension)  { 
        case 'jpg':$result = imagejpeg($this->img_resource, $this->folder.$this->fileNewName, 100 );  break; // best quality
        case 'jpeg':$result = imagejpeg($this->img_resource, $this->folder.$this->fileNewName, 100 );  break; // best quality
        case 'png':$result = imagepng($this->img_resource, $this->folder.$this->fileNewName, 0); break; // no compression
        default: $this->message .='Il formato file '.$this->fileExtension.' non è supportato';
    }
    
    if ( !$result ) {
        $this->message .= "Impossibile salvare l'immagine";
    }  
}





}