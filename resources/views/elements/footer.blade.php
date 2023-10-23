<footer class="footer footer-center p-10 text-left shadow-md bg-base-100 dark:bg-base-300">
    <div class="lg:container text-center w-full mx-auto">
        <div class="w-full">
            &copy; {{ date('Y', time()) }} {{ config('bds.info.full_name') }}. Tous droits réservés.
        </div>
        <div class="w-full">
            <x-icon name="fas-code" class="h-5 w-5 font-bold inline"></x-icon> avec <x-icon name="fas-coffee" class="h-5 w-5 inline" style="color: #826644"></x-icon> par <a href="https://github.com/Xety" target="_blank" class="link link-hover link-primary font-bold">Emeric Fèvre</a>
        </div>
    </div>
</footer>
