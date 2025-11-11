{include file="header.tpl"}
<section class="vs-auth">
    <div class="vs-auth-card">
        <h1>{$LANG.login}</h1>
        {if $incorrect}
            <div class="vs-alert">{$LANG.loginincorrect}</div>
        {/if}
        <form method="post" action="dologin.php">
            <div class="vs-field">
                <label for="inputEmail">{$LANG.loginemail}</label>
                <input type="email" name="username" id="inputEmail" value="{$username}" required>
            </div>
            <div class="vs-field">
                <label for="inputPassword">{$LANG.loginpassword}</label>
                <input type="password" name="password" id="inputPassword" required>
            </div>
            <div class="vs-field vs-field-inline">
                <label>
                    <input type="checkbox" name="rememberme" /> {$LANG.loginrememberme}
                </label>
                <a href="pwreset.php">{$LANG.forgotpw}</a>
            </div>
            <button type="submit" class="vs-button">{$LANG.login}</button>
        </form>
        <p class="vs-auth-switch">{$LANG.loginnoacc} <a href="register.php">{$LANG.logincreate}</a></p>
    </div>
</section>
{include file="footer.tpl"}
