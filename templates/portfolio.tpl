<div id="portfolio">{foreach from=$portfolio item=row name=f}<div id="tr{$smarty.foreach.f.index}" class="tr" data="{$smarty.foreach.f.index}">{foreach from=$row item=p}<div class="li"><img src="/images/uploads/{$p.portfolio_avatar_id.name}_s.{$p.portfolio_avatar_id.ext}" data="{$p.portfolio_id}" /></div>{/foreach}</div>{foreachelse}Нет портфолио!{/foreach}</div>
<script src="/js/portfolio.js"></script>
