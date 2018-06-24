<main role="main">
    <h1>Profilo di&nbsp;<?=$data->user_name?></h1>
        <img src="/img/auth/<?=!empty($data->user_image)?$data->user_image:'default.jpg'?>" alt="avatar personale">
        <?php if ( isset($_SESSION['user_id']) &&  $data->ID === $_SESSION['user_id'] ): ?>
        <form action='/auth/<?=$data->ID?>/image' method='POST' autocomplete='off' enctype="multipart/form-data">
        <?php if (!empty($message)): ?>
        <div class='message'><?=$message?>
        <div class="message-close">X</div>
        </div><?php endif?>
        <label for="file">Cambia immagine</label>
        <input type="file" name="file" id="file"> 
        <button type='submit' class="button">Invia</button>
        </form>
        <?php endif?>
        <table>
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
                        <a href='/auth/<?=$data->ID?>/banned'>banned</a>
                        <a href='/auth/<?=$data->ID?>/reader'>reader</a>
                        <a href='/auth/<?=$data->ID?>/contributor'>contributor </a>
                        <a href='/auth/<?=$data->ID?>/administrator'>administrator</a>
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
</main>









