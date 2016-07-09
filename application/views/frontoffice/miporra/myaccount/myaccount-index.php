<div class="fancy-title ">
    <h3>Mi <span>Perfil</span> </h3>
</div>

<p>Loorerem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat, eos quibusdam accusamus. Maiores, distinctio similique at fugiat reiciendis corporis pariatur. Iusto, molestiae odio ullam quas ratione! Explicabo, sunt, totam mollitia eveniet quasi commodi maxime impedit quos magni deleniti? Laborum, ad, necessitatibus minima officiis mollitia commodi quia dolore enim animi doloribus.</p>

<form id="myaccount-form" name="myaccount-form" class="nobottommargin" action="" method="post">
                        <div class="col_half">
                <label for="myaccount-form-name">Firstname:</label>
                <input type="text" id="myaccount-form-firstname" name="myaccount-form-firstname" value="<?=$user->firstname?>" class="form-control">
            </div>

            <div class="col_half col_last">
                <label for="myaccount-form-name">Lastname:</label>
                <input type="text" id="myaccount-form-lastname" name="myaccount-form-lastname" value="<?=$user->lastname?>" class="form-control">
            </div>



            <div class="clear"></div>


            <div class="col_half">
                <label for="myaccount-form-username">Choose a Username:</label>
                <input type="text" id="myaccount-form-username" name="myaccount-form-username" value="<?=$user->nick?>" class="form-control">
            </div>

            <div class="col_half col_last">
                <label for="myaccount-form-email">Email Address:</label>
                <input type="text" id="myaccount-form-email" name="myaccount-form-email" value="<?=$user->email?>" class="form-control">
            </div>


            <div class="clear"></div>

            <div class="col_half">
                <label for="myaccount-form-password">Choose Password:</label>
                <input type="password" id="myaccount-form-password" name="myaccount-form-password" value="" class="form-control">
            </div>

            <div class="col_half col_last">
                <label for="myaccount-form-repassword">Re-enter Password:</label>
                <input type="password" id="myaccount-form-repassword" name="myaccount-form-repassword" value="" class="form-control">
            </div>

            <div class="clear"></div>


            <div class="col_full nobottommargin">
                <button class="button button-3d button-black nomargin" id="myaccount-form-submit" name="myaccount-form-submit" value="register">Enviar</button>
            </div>

        </form>