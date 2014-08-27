{extends file='page.tpl'}
{block name='title'}{$article.news_meta_title}{/block}
{block name='meta_description'}{$article.news_meta_description}{/block}
{block name='meta_keywords'}{$article.news_meta_keywords}{/block}
{block name='links' append}
  <link href="/css/header.css" rel="stylesheet" />
  <link href="/css/footer.css" rel="stylesheet" />
  <link href="/css/resume.css" rel="stylesheet" />
  <link href="/css/forms.css" rel="stylesheet" />  
  <link href="/css/jquery.bxslider.css" rel="stylesheet" />
  <script src="/js/jquery.bxslider.js"></script>
  <script>
    $(function(){
       $('.bxslider').bxSlider({
         'auto'          : true,
         'controls'      : true,
         'speed'         : 1000,
         'pause'         : 5000,
         'easing'        : 'ease-in-out',
         'adaptiveHeight': false,
         'infiniteLoop'  : true,
         'touchEnabled'  : false
       });
     });
  </script>
{/block}
{block name='div.main'}
   {include file="header.tpl"}
   <div class="wrap_resume">
      <div class="lineh1">
         <h1>Резюме</h1>
      </div>
   </div>
   <ul class="bxslider">
      <li>
         <article class="slider_text">
           <h1>Наша профессиональная деятельность</h1>
           <div class="text">
              <ul>
                <li>- креатив: разработка и проведение рекламных кампаний; сценарии промоакций, событийные мероприятия, презентации, копирайт (от поздравления в стихах до PR-статьи)</li>
                <li>- дизайн: дизайн рекламной кампании, фирменный стиль, наружная реклама, полиграфия</li>
                <li>- видео: 2D и 3D-анимация, компьютерная графика, постановочные видеоролики, корпоративные фильмы, ТВ-сюжеты, аудиоролики, авторские ТВ-программы</li>
                <li>- BTL: промоакции, дегустации, сэмплинг, вечеринки, event- marketing, Direct-marketing, вирусный маркетинг</li>
                <li>- производство: наружная реклама, оригинальные конструкции, архитектурная подсветка, реклама на транспорте, полиграфия</li>
                <li>- Интернет-продвижение: оптимизация сайта, редактирование, контекстная реклама, интерактивные акции и др.</li>
                <li>- размещение в СМИ: размещение в местных, региональных и центральных СМИ, авторский контроль</li>
                <li>- размещение наружной рекламы: биллборды 3х6, транспарант-перетяжки, сити-форматы, лайт-боксы, нестандартные поверхности</li>
                <li>- реклама на транспорте: брендирование бортов, размещение в чехлах, размещение листовок внутри салона</li>
                <li>- INDOOR (реклама в супермаркетах): брендирование шкафчиков, тележек, размещение х-стоек, напольных стикеров, шелфтокеров, воблеров, мобайлов.</li>
              </ul>
            </div>
         </article>
         <img src="/images/resume.jpg" />
      </li><li>
         <article class="slider_text">
           <h1>Наша профессиональная деятельность</h1>
           <div class="text">
              <ul>
                <li>- креатив: разработка и проведение рекламных кампаний; сценарии промоакций, событийные мероприятия, презентации, копирайт (от поздравления в стихах до PR-статьи)</li>
                <li>- дизайн: дизайн рекламной кампании, фирменный стиль, наружная реклама, полиграфия</li>
                <li>- видео: 2D и 3D-анимация, компьютерная графика, постановочные видеоролики, корпоративные фильмы, ТВ-сюжеты, аудиоролики, авторские ТВ-программы</li>
                <li>- BTL: промоакции, дегустации, сэмплинг, вечеринки, event- marketing, Direct-marketing, вирусный маркетинг</li>
                <li>- производство: наружная реклама, оригинальные конструкции, архитектурная подсветка, реклама на транспорте, полиграфия</li>
                <li>- Интернет-продвижение: оптимизация сайта, редактирование, контекстная реклама, интерактивные акции и др.</li>
                <li>- размещение в СМИ: размещение в местных, региональных и центральных СМИ, авторский контроль</li>
                <li>- размещение наружной рекламы: биллборды 3х6, транспарант-перетяжки, сити-форматы, лайт-боксы, нестандартные поверхности</li>
                <li>- реклама на транспорте: брендирование бортов, размещение в чехлах, размещение листовок внутри салона</li>
                <li>- INDOOR (реклама в супермаркетах): брендирование шкафчиков, тележек, размещение х-стоек, напольных стикеров, шелфтокеров, воблеров, мобайлов.</li>
              </ul>
            </div>
         </article>
         <img src="/images/resume.jpg" />
      </li><li>
         <article class="slider_text">
           <h1>Наша профессиональная деятельность</h1>
           <div class="text">
              <ul>
                <li>- креатив: разработка и проведение рекламных кампаний; сценарии промоакций, событийные мероприятия, презентации, копирайт (от поздравления в стихах до PR-статьи)</li>
                <li>- дизайн: дизайн рекламной кампании, фирменный стиль, наружная реклама, полиграфия</li>
                <li>- видео: 2D и 3D-анимация, компьютерная графика, постановочные видеоролики, корпоративные фильмы, ТВ-сюжеты, аудиоролики, авторские ТВ-программы</li>
                <li>- BTL: промоакции, дегустации, сэмплинг, вечеринки, event- marketing, Direct-marketing, вирусный маркетинг</li>
                <li>- производство: наружная реклама, оригинальные конструкции, архитектурная подсветка, реклама на транспорте, полиграфия</li>
                <li>- Интернет-продвижение: оптимизация сайта, редактирование, контекстная реклама, интерактивные акции и др.</li>
                <li>- размещение в СМИ: размещение в местных, региональных и центральных СМИ, авторский контроль</li>
                <li>- размещение наружной рекламы: биллборды 3х6, транспарант-перетяжки, сити-форматы, лайт-боксы, нестандартные поверхности</li>
                <li>- реклама на транспорте: брендирование бортов, размещение в чехлах, размещение листовок внутри салона</li>
                <li>- INDOOR (реклама в супермаркетах): брендирование шкафчиков, тележек, размещение х-стоек, напольных стикеров, шелфтокеров, воблеров, мобайлов.</li>
              </ul>
            </div>
         </article>
         <img src="/images/resume.jpg" />
      </li><li>
         <article class="slider_text">
           <h1>Наша профессиональная деятельность</h1>
           <div class="text">
              <ul>
                <li>- креатив: разработка и проведение рекламных кампаний; сценарии промоакций, событийные мероприятия, презентации, копирайт (от поздравления в стихах до PR-статьи)</li>
                <li>- дизайн: дизайн рекламной кампании, фирменный стиль, наружная реклама, полиграфия</li>
                <li>- видео: 2D и 3D-анимация, компьютерная графика, постановочные видеоролики, корпоративные фильмы, ТВ-сюжеты, аудиоролики, авторские ТВ-программы</li>
                <li>- BTL: промоакции, дегустации, сэмплинг, вечеринки, event- marketing, Direct-marketing, вирусный маркетинг</li>
                <li>- производство: наружная реклама, оригинальные конструкции, архитектурная подсветка, реклама на транспорте, полиграфия</li>
                <li>- Интернет-продвижение: оптимизация сайта, редактирование, контекстная реклама, интерактивные акции и др.</li>
                <li>- размещение в СМИ: размещение в местных, региональных и центральных СМИ, авторский контроль</li>
                <li>- размещение наружной рекламы: биллборды 3х6, транспарант-перетяжки, сити-форматы, лайт-боксы, нестандартные поверхности</li>
                <li>- реклама на транспорте: брендирование бортов, размещение в чехлах, размещение листовок внутри салона</li>
                <li>- INDOOR (реклама в супермаркетах): брендирование шкафчиков, тележек, размещение х-стоек, напольных стикеров, шелфтокеров, воблеров, мобайлов.</li>
              </ul>
            </div>
         </article>
         <img src="/images/resume.jpg" />
      </li>
   </ul>
   {include file="footer.tpl"} 
{/block}