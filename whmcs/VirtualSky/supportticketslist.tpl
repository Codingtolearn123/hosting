{extends file="clientarealayout.tpl"}
{block name="templateOutput"}
<section class="vs-listing">
    <header class="vs-listing-header">
        <h1>{$LANG.supportticketsopentickets}</h1>
        <a class="vs-button" href="submitticket.php">{$LANG.navopenticket}</a>
    </header>
    <div class="vs-table">
        <div class="vs-table-head">
            <span>{$LANG.supportticketsdate}</span>
            <span>{$LANG.supportticketssubject}</span>
            <span>{$LANG.supportticketsdepartment}</span>
            <span>{$LANG.clientareastatus}</span>
        </div>
        {foreach from=$tickets item=ticket}
            <a class="vs-table-row" href="viewticket.php?tid={$ticket.tid}&c={$ticket.c}">
                <span>{$ticket.date}</span>
                <span>#{$ticket.tid} {$ticket.subject}</span>
                <span>{$ticket.department}</span>
                <span class="status status-{$ticket.status|lower}">{$ticket.status}</span>
            </a>
        {foreachelse}
            <div class="vs-table-empty">{$LANG.supportticketsnoneopen}</div>
        {/foreach}
    </div>
</section>
{/block}
