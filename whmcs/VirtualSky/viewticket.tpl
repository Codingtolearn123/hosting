{extends file="clientarealayout.tpl"}
{block name="templateOutput"}
<section class="vs-ticket">
    <header class="vs-ticket-header">
        <h1>#{$ticket.tid} - {$ticket.subject}</h1>
        <span class="status status-{$ticket.status|lower}">{$ticket.status}</span>
    </header>
    <div class="vs-ticket-messages">
        {foreach from=$ticketlog item=message}
            <article class="vs-ticket-message {if $message.admin}admin{else}client{/if}">
                <header>
                    <strong>{if $message.admin}{$message.admin}{else}{$ticket.name}{/if}</strong>
                    <span>{$message.date}</span>
                </header>
                <div class="vs-ticket-body">{$message.message}</div>
            </article>
        {/foreach}
    </div>
    <form method="post" action="viewticket.php?tid={$ticket.tid}&c={$ticket.c}" enctype="multipart/form-data" class="vs-ticket-reply">
        <h2>{$LANG.supportticketsreply}</h2>
        <textarea name="replymessage" rows="6" required></textarea>
        <div class="vs-ticket-actions">
            <button type="submit" class="vs-button">{$LANG.supportticketsticketsubmit}</button>
        </div>
    </form>
</section>
{/block}
