
<div class="entry clearfix">
<div class="fancy-title ">
    <h3>Mis <span>Grupos</span> </h3>
</div>

<p>Desde aquí podrás crear y administrar tus grupos así como enviar invitaciones para que la gente administre tu grupo. Inscribir a tu grupo a las distintas competiciones y configuralas a tu gusto.</p>

<div class="style-msg alertmsg">
    <div class="sb-msg"><i class="icon-warning-sign"></i><strong>Atención!</strong> No tienes ningún grupo creado.</div>
</div>

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

<div class="col_full nobottommargin">
    <button class="button button-small fright button-black" id="create-group" name="create-group" value="create-group">Unirse a grupo</button>
    <button class="button button-small fright " id="create-group" name="create-group" value="create-group">Crear Grupo</button>
    
</div>

<div class="clear"></div>

</div>


<div class="entry clearfix hidden">
<div class="fancy-title ">
    <h3>Otros <span>Grupos</span> </h3>
</div>

<p>Listado de grupos externos a los que estas registrado.</p>
<div class="style-msg alertmsg">
    <div class="sb-msg"><i class="icon-warning-sign"></i><strong>Atención!</strong> No eres miembro de ningun otro grupo.</div>
</div>
</div>