<?php
    include "app/views/".Route::$language.'/profile_'.Route::$language.'.php';
?>

<div class='container'>
    <h1><?php echo $lng['hi'].' '.$data['username'];?></h1>
    <h4><?php echo $lng['your_email'].' '.$data['email'];?></h4>
    <h4><?php echo $lng['your_avatar'];?></h4>
    <img src="<?php echo $data['picture'];?>" style="max-width:50%;" class="img-circle">
</div>