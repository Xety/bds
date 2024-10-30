<footer class="relative footer text-base bg-[#1b252f] text-white p-10 pt-[15%] lg:pt-[5%]">
    <div class="absolute w-full -top-0.5 left-0 fill-white">
        <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="primaryColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path d="M0,6V0h1000v100L0,6z"></path>
        </svg>
    </div>
    <nav>
        <h6 class="footer-title">Services</h6>
        <a class="link link-hover">Branding</a>
        <a class="link link-hover">Design</a>
        <a class="link link-hover">Marketing</a>
        <a class="link link-hover">Advertisement</a>
    </nav>
    <nav>
        <h6 class="footer-title">Company</h6>
        <a class="link link-hover">About us</a>
        <a class="link link-hover">Contact</a>
        <a class="link link-hover">Jobs</a>
        <a class="link link-hover">Press kit</a>
    </nav>
    <nav>
        <h6 class="footer-title">Legal</h6>
        <a class="link link-hover">Terms of use</a>
        <a class="link link-hover">Privacy policy</a>
        <a class="link link-hover">Cookie policy</a>
    </nav>
</footer>

<footer class="flex flex-col items-center bg-[#1b252f] text-white border-base-300 border-t border-opacity-50 px-10 py-4">
    <div>
        <x-icon name="fas-phone" class="h-5 w-5 inline"></x-icon> 03 85 91 93 00
    </div>
    <div>
        <x-icon name="fas-map-marker-alt" class="h-5 w-5 inline"></x-icon> 6 avenue du Président Borgeot, 71350 Verdun-sur-le-doubs
    </div>
    <div>
        <x-icon name="far-clock" class="h-5 w-5 inline"></x-icon> 08:00 12:30 - 13:30 18:00
    </div>
</footer>

<footer class="footer text-base bg-[#1b252f] text-white border-base-300 border-t border-opacity-50 px-10 py-4">
    <aside class="grid-flow-col items-center">
        <img src="{{ asset('images/logos/cbds_324x383.png') }}" alt="Coopérative Bourgogne du Sud Logo" class="inline-block w-14">
        <p>
            &copy; {{ date('Y', time()) }} {{ config('bds.info.full_name') }}.
            <br />
            Tous droits réservés.
        </p>
    </aside>
    <nav class="md:place-self-center md:justify-self-end">
        <div class="grid grid-flow-col gap-4">
            <a href="https://www.facebook.com/coopbourgognedusud/" target="_blank" class="tooltip" data-tip="Notre Facebook">
                <x-icon name="fab-facebook-f" class="h-7 w-7"></x-icon>
            </a>
            <a href="https://www.linkedin.com/company/7314452/admin/" target="_blank" class="tooltip" data-tip="Notre Linkedin">
                <x-icon name="fab-linkedin-in" class="h-8 w-8"></x-icon>
            </a>
            <a href="https://www.instagram.com/bourgognedusud/" target="_blank" class="tooltip" data-tip="Notre Instagram">
                <x-icon name="fab-instagram" class="h-8 w-8"></x-icon>
            </a>
        </div>
    </nav>
</footer>
