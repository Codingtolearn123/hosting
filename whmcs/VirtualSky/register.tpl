{include file="header.tpl"}
<section class="vs-auth">
    <div class="vs-auth-card">
        <h1>{$LANG.register}</h1>
        <form method="post" action="register.php" class="using-password-strength">
            <input type="hidden" name="register" value="true" />
            {foreach from=$register.formfields item=field}
                <div class="vs-field">
                    <label for="{$field.id}">{$field.name}</label>
                    {$field.input}
                </div>
            {/foreach}
            <button type="submit" class="vs-button">{$LANG.register}</button>
        </form>
        <p class="vs-auth-switch">{$LANG.registeralreadyclient} <a href="clientarea.php">{$LANG.login}</a></p>
    </div>
</section>
{include file="footer.tpl"}
