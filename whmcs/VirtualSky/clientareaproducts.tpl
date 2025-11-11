{extends file="clientarealayout.tpl"}
{block name="templateOutput"}
<section class="vs-listing">
    <header class="vs-listing-header">
        <h1>{$LANG.navservices}</h1>
        <a class="vs-button" href="#" data-whmcs-target="web-hosting">{$LANG.ordernewservice}</a>
    </header>
    <div class="vs-table">
        <div class="vs-table-head">
            <span>{$LANG.orderproduct}</span>
            <span>{$LANG.clientareahostingnextduedate}</span>
            <span>{$LANG.orderpaymentterm}</span>
            <span>{$LANG.clientareastatus}</span>
        </div>
        {foreach from=$services item=service}
            <a class="vs-table-row" href="clientarea.php?action=productdetails&id={$service.id}">
                <span>{$service.product}</span>
                <span>{$service.nextduedate}</span>
                <span>{$service.billingcycle}</span>
                <span class="status status-{$service.statustext|lower}">{$service.statustext}</span>
            </a>
        {foreachelse}
            <div class="vs-table-empty">{$LANG.clientareanoaddons}</div>
        {/foreach}
    </div>
</section>
{/block}
