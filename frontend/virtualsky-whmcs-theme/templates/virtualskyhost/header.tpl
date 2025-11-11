{* VirtualSkyHost WHMCS Header *}
<!DOCTYPE html>
<html lang="{$language}">
<head>
    <meta charset="{$charset}" />
    <title>{if $pagetitle}{$pagetitle} - {/if}Virtual Sky</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.3/dist/tailwind.min.css" rel="stylesheet" />
    <link href="{$WEB_ROOT}/templates/{$template}/css/virtualsky.css" rel="stylesheet" />
    {$headoutput}
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col" data-theme="dark">
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-slate-950/80 border-b border-white/10">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between gap-6">
            <a href="{$WEB_ROOT}/index.php" class="flex items-center gap-3 text-white">
                <span class="h-12 w-12 rounded-2xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-indigo-500/40 font-bold">VS</span>
                <span class="text-left">
                    <span class="block text-lg font-semibold tracking-wide">Virtual Sky</span>
                    <span class="block text-xs uppercase tracking-[0.4em] text-indigo-200/90">AI Cloud Hosting</span>
                </span>
            </a>
            <nav class="hidden md:flex items-center gap-6 text-sm">
                <a class="hover:text-indigo-200 transition" href="{$WEB_ROOT}/index.php?rp=/store/shared-hosting">{lang key='navSharedHosting'}</a>
                <a class="hover:text-indigo-200 transition" href="{$WEB_ROOT}/index.php?rp=/store/wordpress-hosting">WordPress</a>
                <a class="hover:text-indigo-200 transition" href="{$WEB_ROOT}/index.php?rp=/store/vps-hosting">VPS</a>
                <a class="hover:text-indigo-200 transition" href="{$WEB_ROOT}/clientarea.php">Client Area</a>
            </nav>
            <a class="hidden md:inline-flex px-4 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold shadow" href="{$WEB_ROOT}/cart.php?a=view">{lang key='navViewCart'}</a>
        </div>
    </header>
    <main class="flex-1">
