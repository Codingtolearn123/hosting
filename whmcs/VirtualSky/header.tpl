{* VirtualSky WHMCS Theme Header *}
<!DOCTYPE html>
<html lang="{$LANG.language}">
<head>
    <meta charset="utf-8">
    <title>{if $pagetitle}{$pagetitle} - {/if}{$companyname}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600&display=swap">
    <link href="{$assetPath}/assets/css/style.css?v=1.0.0" rel="stylesheet">
    {if $favicon}<link rel="shortcut icon" href="{$favicon}">{/if}
    {$headoutput}
</head>
<body class="virtualsky-theme">
<div class="vs-shell">
    <aside class="vs-sidebar" aria-label="Main navigation">
        <div class="vs-brand">
            <div class="vs-logo">VS</div>
            <div class="vs-company">{$companyname}</div>
        </div>
        <nav class="vs-nav">
            <ul>
                <li class="{if $templatefile eq 'clientareahome'}active{/if}"><a href="clientarea.php"><i class="vs-icon fas fa-home"></i> {$LANG.clientHomePanelsLatestNews}</a></li>
                <li><a href="#" data-whmcs-target="web-hosting"><i class="vs-icon fas fa-layer-group"></i> Web Hosting</a></li>
                <li><a href="#" data-whmcs-target="reseller-hosting"><i class="vs-icon fas fa-store"></i> Reseller</a></li>
                <li><a href="#" data-whmcs-target="vps-cloud"><i class="vs-icon fas fa-server"></i> VPS & Cloud</a></li>
                <li><a href="#" data-whmcs-target="ai-agent-builder"><i class="vs-icon fas fa-robot"></i> AI Agent Builder</a></li>
                <li class="divider"></li>
                <li class="{if $filename eq 'clientarea'}active{/if}"><a href="clientarea.php?action=services"><i class="vs-icon fas fa-box"></i> {$LANG.navservices}</a></li>
                <li class="{if $filename eq 'clientarea' && $action eq 'domains'}active{/if}"><a href="clientarea.php?action=domains"><i class="vs-icon fas fa-globe"></i> {$LANG.navdomains}</a></li>
                <li class="{if $filename eq 'clientarea' && $action eq 'invoices'}active{/if}"><a href="clientarea.php?action=invoices"><i class="vs-icon fas fa-file-invoice"></i> {$LANG.invoices}</a></li>
                <li class="{if $filename eq 'supporttickets'}active{/if}"><a href="supporttickets.php"><i class="vs-icon fas fa-life-ring"></i> {$LANG.navtickets}</a></li>
                <li class="{if $filename eq 'clientarea' && $action eq 'details'}active{/if}"><a href="clientarea.php?action=details"><i class="vs-icon fas fa-user"></i> {$LANG.clientareanavdetails}</a></li>
            </ul>
        </nav>
        <div class="vs-sidebar-footer">
            <button class="vs-mode-toggle" data-vs-toggle-theme type="button">
                <i class="vs-icon fas fa-moon"></i>
                <span>Toggle Theme</span>
            </button>
        </div>
    </aside>
    <div class="vs-main">
        <header class="vs-topbar">
            <div class="vs-topbar-left">
                <span class="vs-page-title">{if $pagetitle}{$pagetitle}{else}{$companyname}{/if}</span>
            </div>
            <div class="vs-topbar-right">
                {if $loggedin}
                    <span class="vs-user">{$clientsdetails.firstname} {$clientsdetails.lastname}</span>
                    <a class="vs-button" href="logout.php">{$LANG.clientareanavlogout}</a>
                {else}
                    <a class="vs-button" href="clientarea.php">{$LANG.login}</a>
                {/if}
            </div>
        </header>
        <main class="vs-content">
            {$headeroutput}
