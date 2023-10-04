<footer class="footer footer-center p-10 text-left shadow-md bg-base-100 dark:bg-base-300">
    <div class="lg:container text-center w-full mx-auto">
        <div class="w-full">
            &copy; {{ date('Y', time()) }} {{ config('bds.info.full_name') }}. Tous droits réservés.
        </div>
        <div class="w-full">
            <i class="fa fa-code text-primary" style="font-weight: bold;"></i> avec <i class="fa fa-coffee" style="color: #826644"></i> par <a href="https://github.com/Xety" target="_blank" class="link link-hover link-primary">Emeric Fèvre</a>
        </div>
    </div>
</footer>
