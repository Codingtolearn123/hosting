    </main>
    <footer class="bg-slate-950/90 border-t border-white/10 py-12">
        <div class="max-w-6xl mx-auto px-6 grid gap-8 md:grid-cols-4 text-sm text-slate-300">
            <div class="space-y-2">
                <span class="block text-lg font-semibold text-white">Virtual Sky</span>
                <p class="text-slate-400">{lang key='copyright'}</p>
            </div>
            <div>
                <h3 class="text-white text-base font-semibold mb-3">{lang key='support'}</h3>
                <ul class="space-y-2">
                    <li><a class="hover:text-white transition" href="{$WEB_ROOT}/submitticket.php">{lang key='navOpenTicket'}</a></li>
                    <li><a class="hover:text-white transition" href="{$WEB_ROOT}/knowledgebase.php">{lang key='knowledgebase'}</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white text-base font-semibold mb-3">Hosting</h3>
                <ul class="space-y-2">
                    <li><a class="hover:text-white transition" href="{$WEB_ROOT}/index.php?rp=/store/shared-hosting">Shared Hosting</a></li>
                    <li><a class="hover:text-white transition" href="{$WEB_ROOT}/index.php?rp=/store/vps-hosting">VPS Hosting</a></li>
                    <li><a class="hover:text-white transition" href="{$WEB_ROOT}/index.php?rp=/store/reseller-hosting">Reseller</a></li>
                </ul>
            </div>
            <div class="space-y-3">
                <h3 class="text-white text-base font-semibold">Need help?</h3>
                <a class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold" href="{$WEB_ROOT}/contact.php">{lang key='contactus'}</a>
            </div>
        </div>
        <div class="max-w-6xl mx-auto px-6 mt-8 pt-6 border-t border-white/10 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500 gap-3">
            <span>&copy; {"Y"|date} Virtual Sky</span>
            <span class="uppercase tracking-[0.3em] text-indigo-200/80">AI Powered Hosting</span>
        </div>
    </footer>
    {$footeroutput}
</body>
</html>
