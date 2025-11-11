{extends file="clientarealayout.tpl"}
{block name="templateOutput"}
<section class="vs-dashboard">
    <div class="vs-welcome-card">
        <div>
            <h1>{$LANG.clientareawelcome} {$clientsdetails.firstname}!</h1>
            <p>{$LANG.helloname} {$clientsdetails.firstname}. {$LANG.clientareahomeorderintro}</p>
            <div class="vs-cta-group">
                <a class="vs-button" href="#" data-whmcs-target="web-hosting">{$LANG.orderForm.orderButton}</a>
                <a class="vs-button ghost" href="supporttickets.php">{$LANG.navopenticket}</a>
            </div>
        </div>
        <div class="vs-stat-grid">
            <div class="vs-stat">
                <span>{$clientsservicesnumactive}</span>
                <small>{$LANG.clientareahomeyourservices}</small>
            </div>
            <div class="vs-stat">
                <span>{$clientsdomainsnumactive}</span>
                <small>{$LANG.clientareahomeyourdomains}</small>
            </div>
            <div class="vs-stat">
                <span>{$clientsinvoicesbalance|default:'0.00'} {$clientsdetails.currency}</span>
                <small>{$LANG.invoicesdue}</small>
            </div>
        </div>
    </div>
    <div class="vs-panels">
        <div class="vs-panel">
            <h2>{$LANG.navservices}</h2>
            <ul>
                {foreach from=$clientsservices item=service}
                    <li>
                        <span>{$service.name}</span>
                        <span class="status status-{$service.status|lower}">{$service.status}</span>
                    </li>
                {/foreach}
            </ul>
        </div>
        <div class="vs-panel">
            <h2>{$LANG.navdomains}</h2>
            <ul>
                {foreach from=$clientsdomains item=domain}
                    <li>
                        <span>{$domain.domain}</span>
                        <span class="status status-{$domain.status|lower}">{$domain.status}</span>
                    </li>
                {/foreach}
            </ul>
        </div>
        <div class="vs-panel">
            <h2>{$LANG.navtickets}</h2>
            <ul>
                {foreach from=$supporttickets item=ticket}
                    <li>
                        <span>#{$ticket.tid} {$ticket.subject}</span>
                        <span class="status status-{$ticket.status|lower}">{$ticket.status}</span>
                    </li>
                {foreachelse}
                    <li>{$LANG.supportticketsnoneopen}</li>
                {/foreach}
            </ul>
        </div>
    </div>
</section>
{include file="includes/ai-widget.tpl"}
{/block}
