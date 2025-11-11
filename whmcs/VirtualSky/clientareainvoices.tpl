{extends file="clientarealayout.tpl"}
{block name="templateOutput"}
<section class="vs-listing">
    <header class="vs-listing-header">
        <h1>{$LANG.invoices}</h1>
        <p>{$LANG.invoicesintro}</p>
    </header>
    <div class="vs-table">
        <div class="vs-table-head">
            <span>{$LANG.invoicesdatecreated}</span>
            <span>{$LANG.invoicesdescription}</span>
            <span>{$LANG.invoicesamountdue}</span>
            <span>{$LANG.clientareastatus}</span>
        </div>
        {foreach from=$invoices item=invoice}
            <a class="vs-table-row" href="viewinvoice.php?id={$invoice.id}">
                <span>{$invoice.date}</span>
                <span>{$invoice.invoicenum}</span>
                <span>{$invoice.total}</span>
                <span class="status status-{$invoice.status|lower}">{$invoice.status}</span>
            </a>
        {foreachelse}
            <div class="vs-table-empty">{$LANG.invoicesnone}</div>
        {/foreach}
    </div>
</section>
{/block}
