{include file="header.tpl"}
<section class="py-16 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950">
    <div class="max-w-5xl mx-auto px-6 space-y-8">
        <div class="text-center space-y-4">
            <span class="px-4 py-1 rounded-full bg-white/5 border border-white/10 text-xs uppercase tracking-[0.3em] text-indigo-200/90">{lang key='orderForm.checkout'}</span>
            <h1 class="text-4xl font-semibold text-white">{lang key='orderForm.reviewAndCheckout'}</h1>
            <p class="text-slate-300">{lang key='orderForm.applyPromoCode'}</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl p-8 space-y-6">
            {$cartoutput}
        </div>
    </div>
</section>
{include file="footer.tpl"}
