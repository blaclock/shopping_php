@if ($user === 'customer')
    <footer
        class="h-[60px] md:h-[80px] mb-[60px] md:mb-0 flex flex-wrap px-10  items-center relative text-{{ $footerTextColor }} bg-{{ $footerBgColor }}">
        <p class="copy-right">&copy;2023.Tomohiro Kuroiwa</p>
    </footer>
@endif

<div class="opacity-0 duration-200 fixed bottom-20 right-5 md:right-10 rounded-full w-10 md:w-20 h-10 md:h-20 bg-gray-500 flex justify-center items-center z-50"
    id="toTopBtn">
    <span class="text-xs md:text-base text-white">TOP</span>
</div>

<script language="JavaScript" type="text/javascript"
    src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ App\consts\CommonConst::JS_PATH }}common.js"></script>
@if ($user === 'customer')
    <script src="{{ App\consts\CommonConst::JS_PATH }}header_menu.js"></script>
@else
    <script src="{{ App\consts\CommonConst::JS_PATH }}/admin/header_menu.js"></script>
@endif
@stack('js')
