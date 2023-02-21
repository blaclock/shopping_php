<footer
    class="h-[60px] md:h-[80px] mb-[60px] md:mb-0 container flex flex-wrap px-10  items-center relative text-{{ $footerTextColor }} bg-{{ $footerBgColor }}">
    <p class="copy-right">&copy;2023.Tomohiro Kuroiwa</p>
</footer>

<script language="JavaScript" type="text/javascript"
    src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="{{ App\consts\CommonConst::JS_PATH }}header_menu.js"></script>
@stack('js')
