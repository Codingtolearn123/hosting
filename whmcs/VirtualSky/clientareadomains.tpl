{extends file="clientarealayout.tpl"}
{block name="templateOutput"}
<section class="vs-listing">
    <header class="vs-listing-header">
        <h1>{$LANG.navdomains}</h1>
        <a class="vs-button" href="cart.php?a=add&domain=register">{$LANG.registerdomain}</a>
    </header>
    <div class="vs-table">
        <div class="vs-table-head">
            <span>{$LANG.clientareahostingdomain}</span>
            <span>{$LANG.clientareahostingnextduedate}</span>
            <span>{$LANG.clientareastatus}</span>
        </div>
        {foreach from=$domains item=domain}
            <a class="vs-table-row" href="clientarea.php?action=domaindetails&id={$domain.id}">
                <span>{$domain.domain}</span>
                <span>{$domain.nextduedate}</span>
                <span class="status status-{$domain.status|lower}">{$domain.status}</span>
            </a>
        {foreachelse}
            <div class="vs-table-empty">{$LANG.clientareanoaddons}</div>
        {/foreach}
    </div>
</section>
{/block}
