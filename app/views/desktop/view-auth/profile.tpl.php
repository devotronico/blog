<main role="main">
    <div id='profile'>
        <h1>Profilo di&nbsp;<?=$data->user_name?></h1>
        <img src="/img/auth/<?=!empty($data->user_image)?$data->user_image:'default.jpg'?>" alt="avatar personale">
        <?php if ($data->ID === $_SESSION['user_id']): ?>
        <form id='profile-form' action='/auth/<?=$data->ID?>/image' method='POST' autocomplete='off' enctype="multipart/form-data">
            <p class='container-title text-center'>Cambia immagine</p>
            <?php if (isset($message)): ?>
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <p><?=$message?></p>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            </div>
            <?php endif?>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">&#x1F5BC</div>
                    <input type="file" class="form-control" name="file"> 
                    <button type='submit' id="profile-btn" class='btn'>Invia</button>
                </div>
            </div>
        </form>
        <?php endif?>

        <div class="table-responsive">
        <table class="table">
            <tbody>
                <tr>
                    <td>Nome</td>
                    <td><?=$data->user_name?></td>
                </tr>
                <tr>
                    <td>Permessi</td>
                    <td><?=$data->user_type?></td>     
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?=$data->user_email?></td>
                </tr>
                <tr>
                    <td>Data Registrazione</td>
                    <td><?=$data->user_registered?></td>
                </tr>
          
               
                <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'administrator' ) :?>
                <tr>
                    <td>Modifica permessi</td>
                    <td>
                        <a class='badge badge-primary' href='/auth/<?=$data->ID?>/banned'>banned</a>
                        <a class='badge badge-primary' href='/auth/<?=$data->ID?>/reader'>reader</a>
                        <a class='badge badge-primary' href='/auth/<?=$data->ID?>/contributor'>contributor </a>
                        <a class='badge badge-primary' href='/auth/<?=$data->ID?>/administrator'>administrator</a>
                    </td>
                </tr>
                <?php endif;?>
                <?php if ( $data->user_type !== 'reader' ) :?>
                <tr>
                    <td>Totale post</td>
                    <td><?=$data->user_num_posts?></td>
                </tr>
                <tr>
                    <td> 
                        <p>Ultimo post<br><?=$data->dateformatted?></p>
                    </td>  
                    <td><?=isset($data->title)?"<a href='/post/$data->post_ID'>$data->title</a>":'nessun post pubblicato'?></td>
                </tr>
                <?php endif;?>
                <tr>
                    <td>Totale commenti</td>
                    <td><?=$data->user_num_comments?></td>
                </tr>
                <tr>
                    <td>
                        <p>Ultimo commento<br><?=$data->c_dateformatted?></p>
                    </td>
                    <td><?=isset($data->comment)?"<a href='/post/$data->post_id'>$data->comment</a>":'nessun commento pubblicato'?></td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</main>









