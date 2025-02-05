@extends('layouts.public')
{!! config(['app.title' => 'Nos Sites']) !!}

@push('meta')
    <x-meta title="Nos Sites"/>
@endpush

@push('style')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    @vite('resources/css/leaflet.css')
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @vite('resources/js/leaflet.js')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const filterSlider = new Swiper('#filters .swiper', {
                speed: 500,
                navigation: {
                    prevEl: '#filters .prev',
                    nextEl: '#filters .next',
                },
                freeMode: {
                    enabled: true,
                    momentum: true,
                    momentumBounce: true,
                },
                spaceBetween: 12,
                slidesPerView: 'auto',
                breakpoints: {
                    575: {
                        spaceBetween: 24,
                    },
                }
            });

            const activeButton = document.querySelector('#filters .active');
            activeButton.click();

            // Init map
            const map = new L.Map('map', {
                center: [46.752, 4.831],
                zoom: 9,
                minZoom: 8,
                maxZoom: 17,
                scrollWheelZoom: true,
                markerZoomAnimation: true,
                zoomControl: true,
                attributionControl: false,
            });

            let sites = {};
            axios.get('{{ route('public.page.sites.index') }}')
                .then(function (response) {
                    sites = response.data;

                    init();
                })
                .catch(function (error) {
                    console.log(error);
                });

            function init() {


                const groups = [];

                const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 17,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);


                const icons = [];
                const bounds = L.latLngBounds();

                // SIEGE SOCIAL
                let html = '';
                html += '<div class="leaflet-marker-icon-inner" style="background-color:#e02a18"></div>';
                html += '<div class="leaflet-marker-icon-open" style="background-color:#e02a18"></div>';
                icons[1] = L.divIcon({
                    html: html,
                    iconSize: [20, 20],
                    iconAnchor: [12, 12],
                });

                let group = [];


                for (const siege of sites['siege-social']) {
                    let marker = L.marker([siege.coordinates.lat, siege.coordinates.long], {icon: icons[1]});
                    marker.addTo(map);
                    marker.on('click', function(e) {
                        clickMarker(e.target, siege);
                    });
                    group.push(marker);
                }

                groups['siege-social'] = new L.FeatureGroup(group).addTo(map);
                bounds.extend(groups['siege-social'].getBounds());

                // GAMM VERT
                html = '';
                html += '<div class="leaflet-marker-icon-inner" style="background-color:#006c50"></div>';
                html += '<div class="leaflet-marker-icon-open" style="background-color:#006c50"></div>';
                icons[2] = L.divIcon({
                    html: html,
                    iconSize: [20, 20],
                    iconAnchor: [12, 12],
                });

                group = [];
                for (const gv of sites['gamm-vert']) {
                    marker = L.marker([gv.coordinates.lat, gv.coordinates.long], {icon: icons[2]});
                    marker.addTo(map);
                    marker.on('click', function(e) {
                        clickMarker(e.target, gv);
                    });
                    group.push(marker);
                }

                groups['gamm-vert'] = new L.FeatureGroup(group).addTo(map);
                bounds.extend(groups['gamm-vert'].getBounds());

                // SILOS
                html = '';
                html += '<div class="leaflet-marker-icon-inner" style="background-color:#feba00"></div>';
                html += '<div class="leaflet-marker-icon-open" style="background-color:#feba00"></div>';
                icons[3] = L.divIcon({
                    html: html,
                    iconSize: [20, 20],
                    iconAnchor: [12, 12],
                });
                group = [];

                for (const silo of sites['silos']) {
                    marker = L.marker([silo.coordinates.lat, silo.coordinates.long], {icon: icons[3]});
                    marker.addTo(map);
                    marker.on('click', function(e) {
                        clickMarker(e.target, silo);
                    });
                    group.push(marker);
                }

                groups['silos'] = new L.FeatureGroup(group).addTo(map);
                bounds.extend(groups['silos'].getBounds());

                // USINES
                html = '';
                html += '<div class="leaflet-marker-icon-inner" style="background-color:#89afd0"></div>';
                html += '<div class="leaflet-marker-icon-open" style="background-color:#89afd0"></div>';
                icons[4] = L.divIcon({
                    html: html,
                    iconSize: [20, 20],
                    iconAnchor: [12, 12],
                });
                group = [];

                for (const usine of sites['usines']) {
                    marker = L.marker([usine.coordinates.lat, usine.coordinates.long], {icon: icons[4]});
                    marker.addTo(map);
                    marker.on('click', function(e) {
                        clickMarker(e.target, usine);
                    });
                    group.push(marker);
                }

                groups['usine'] = new L.FeatureGroup(group).addTo(map);
                bounds.extend(groups['usine'].getBounds());

                // ACTIVITES VIGNES
                html = '';
                html += '<div class="leaflet-marker-icon-inner" style="background-color:#a50343"></div>';
                html += '<div class="leaflet-marker-icon-open" style="background-color:#a50343"></div>';
                icons[5] = L.divIcon({
                    html: html,
                    iconSize: [20, 20],
                    iconAnchor: [12, 12],
                });
                group = [];

                for (const vigne of sites['activites-vigne']) {
                    marker = L.marker([vigne.coordinates.lat, vigne.coordinates.long], {icon: icons[5]});
                    marker.addTo(map);
                    marker.on('click', function(e) {
                        clickMarker(e.target, vigne);
                    });
                    group.push(marker);
                }

                groups['activites-vigne'] = new L.FeatureGroup(group).addTo(map);
                bounds.extend(groups['activites-vigne'].getBounds());


                map.fitBounds(bounds, {padding: [100, 100]});


                map.on('popupopen', function(e) {
                    const el = document.querySelector('.leaflet-popup');

                    const popupWidth = Math.min(375, 425);
                    e.popup.options.minWidth = popupWidth;
                    e.popup.options.maxWidth = popupWidth;
                    e.popup.options.autoPanPadding = L.point(50, 50);
                    e.popup.options.keepInView = true;
                    e.popup.update();

                    const popupHeight = el.offsetHeight;

                    if (window.matchMedia("(min-width: 575px)").matches) {
                        e.popup.options.offset = [popupWidth / 2 + 50, popupHeight / 2 - 25];
                    } else {
                        e.popup.options.offset = [0, 0];

                    }

                    e.popup.update();
                });

                map.on('popupclose', function(e) {
                    document.querySelectorAll('.leaflet-marker-icon').forEach(function(el) {
                        el.classList.remove('leaflet-marker-clicked');
                    });
                });


                document.querySelectorAll('#filters .filter').forEach(function(el, key) {
                    el.addEventListener('click', function(e) {
                        document.querySelectorAll('#filters .filter').forEach(function(el) {
                            el.classList.remove('active');
                        });
                        el.classList.add('active');
                        const slug = el.dataset['slug'];

                        map.eachLayer(function (layer) {
                            if (layer.options.type === undefined && layer._url  === undefined){
                                map.removeLayer(layer);
                            }
                        });

                        if(slug !== '') {
                            map.addLayer(groups[slug]);
                            map.flyToBounds(groups[slug].getBounds(), { padding: [100, 100]});
                        } else {
                            const bounds = L.latLngBounds();
                            map.addLayer(groups['siege-social']);
                            bounds.extend(groups['siege-social'].getBounds());

                            map.addLayer(groups['gamm-vert']);
                            bounds.extend(groups['gamm-vert'].getBounds());

                            map.addLayer(groups['silos']);
                            bounds.extend(groups['silos'].getBounds());

                            map.addLayer(groups['usine']);
                            bounds.extend(groups['usine'].getBounds());

                            map.addLayer(groups['activites-vigne']);
                            bounds.extend(groups['activites-vigne'].getBounds());

                            map.flyToBounds(bounds, { padding: [100, 100]});
                        }
                    });
                });
            }

            function clickMarker(target, data) {
                document.querySelectorAll('.leaflet-marker-icon').forEach(function(el) {
                    el.classList.remove('leaflet-marker-clicked');
                });
                target._icon.classList.add('leaflet-marker-clicked');

                const popupName = document.getElementById('popup-name');
                popupName.textContent = data.name;
                const popupType = document.getElementById('popup-type');
                popupType.innerHTML = data.type;
                const popupItineraire = document.getElementById('popup-itineraire');
                popupItineraire.href = "http://maps.google.com/?q=" + data.address;
                const popupPhone = document.getElementById('popup-phone');
                popupPhone.href = "tel:" + data.phone;

                const popupMail = document.getElementById('popup-mail');
                if (data.email !== undefined) {
                    popupMail.classList.remove('hidden');
                    popupMail.href = "mailto:" + data.email;
                } else {
                    popupMail.classList.add('hidden');
                }

                const popupColor = document.getElementById('popup-color');
                popupColor.style.borderColor = data.color;

                const popupOpeningHours = document.getElementById('popup-opening_hours');
                popupOpeningHours.innerHTML = '';
                for (const [key, hours] of Object.entries(data.opening_hours)) {
                    const li = document.createElement("li");
                    li.setAttribute('class','flex justify-between capitalize');
                    li.innerHTML= "<div>" + key + "</div><div>" + hours + "</div>";

                    popupOpeningHours.appendChild(li);
                }

                const popupPhone2 = document.getElementById('popup-phone2');
                popupPhone2.href = "tel:" + data.phone;
                const popupPhone2Num = document.getElementById('popup-phone2num');
                popupPhone2Num.innerHTML = data.phone;
                const popupItineraire2 = document.getElementById('popup-itineraire2');
                popupItineraire2.href = "http://maps.google.com/?q=" + data.address;
                const popupAddress = document.getElementById('popup-address');
                popupAddress.innerHTML = data.address;


                const popupEmployees = document.getElementById('popup-employees');
                popupEmployees.innerHTML = '';
                for (const employee of data['employees']) {
                    const li = document.createElement("li");
                    li.setAttribute('class','[&:not(:first-child)]:pt-2 [&:not(:first-child)]:mt-2 [&:not(:first-child)]:border-t border-gray-300');
                    const div = document.createElement("div");
                    div.setAttribute('class', 'flex justify-start items-center');

                    const divAvatar = document.createElement("div");
                    divAvatar.setAttribute('class', 'avatar mr-3');
                    const divAvatar2 = document.createElement("div");
                    divAvatar2.setAttribute('class', 'w-16 rounded-full bg-primary');
                    const avatar = document.createElement("img");
                    avatar.setAttribute('src', "{{ asset('images/logos/bds_blanc.png') }}");
                    avatar.setAttribute('alt', employee.name);
                    avatar.setAttribute('class', 'p-2');
                    divAvatar2.appendChild(avatar);
                    divAvatar.appendChild(divAvatar2);
                    div.appendChild(divAvatar);

                    const divInfos = document.createElement("div");
                    const divInfoName = document.createElement("div");
                    divInfoName.setAttribute('class', 'text-primary mb-2');
                    divInfoName.textContent = employee.name;
                    const divInfoFunction = document.createElement("div");
                    divInfoFunction.setAttribute('class', 'text-gray-500');
                    divInfoFunction.textContent = employee.function;
                    divInfos.appendChild(divInfoName);
                    divInfos.appendChild(divInfoFunction);
                    div.appendChild(divInfos);


                    li.appendChild(div);
                    popupEmployees.appendChild(li);
                }



                const popup = document.getElementById('popup');
                L.popup().setLatLng(target._latlng).setContent(popup.outerHTML).openOn(map);
            }

        });
    </script>
@endpush


@section('content')
<section id="filters">
    <button class="prev"><svg stroke="currentColor" fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="7.317" height="12.386" viewBox="0 0 7.317 12.386">
            <path  d="M.722 5.795L5.845.672a.569.569 0 01.8.8L1.924 6.19l4.721 4.724a.569.569 0 01-.8.8L.717 6.59a.569.569 0 010-.8z" />
        </svg></button>
    <div class="swiper">
        <ul class="swiper-wrapper">
            <li class="swiper-slide">
                <button data-slug="" class="filter active">
                    <span>Tous les sites</span>
                </button>
            </li>
            <li class="swiper-slide">
                <button class="filter " data-slug="siege-social">
                    <span class="color" style="background:#c0392b"></span>
                    <span>Siège Social</span>
                </button>
            </li>
            <li class="swiper-slide">
                <button class="filter " data-slug="gamm-vert">
                    <span class="color" style="background:#006c50"></span>
                    <span>Gamm Vert</span>
                </button>
            </li>
            <li class="swiper-slide">
                <button class="filter " data-slug="silos">
                    <span class="color" style="background:#feba00"></span>
                    <span>Silos de collecte</span>
                </button>
            </li>
            <li class="swiper-slide">
                <button class="filter " data-slug="usine">
                    <span class="color" style="background:#89afd0"></span>
                    <span>Usines</span>
                </button>
            </li>
            <li class="swiper-slide">
                <button class="filter " data-slug="activites-vigne">
                    <span class="color" style="background:#a50343"></span>
                    <span>Activité vigne</span>
                </button>
            </li>
        </ul>
    </div>
    <button class="next">
        <svg stroke="currentColor" fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="7.262" height="12.385" viewBox="0 0 7.262 12.385">
            <path d="M6.595 6.595l-5.123 5.123a.569.569 0 01-.8-.8l4.721-4.721L.672 1.476a.569.569 0 01.8-.8l5.123 5.123a.569.569 0 010 .796z" />
        </svg>
    </button>
</section>
<section id="map" class="min-h-dvh"></section>
<section class="relative">
    <div class="absolute w-full -bottom-0.5 left-0 fill-white transform rotate-180">
        <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="primaryColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path d="M0,6V0h1000v100L0,6z"></path>
        </svg>
    </div>
</section>
<div id="popup-wrapper"></div>





<div class="hidden">
    <div id="popup" class="map-popup simplebar-scrollable-y">
        <div class="simplebar-wrapper" style="margin: -16px;">
            <div class="simplebar-mask">
                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                    <div class="simplebar-content-wrapper"  style="height: auto;">
                        <div id="popup-color" class="border-l-8 p-4">
                            <h2 id="popup-name" class="text-2xl text-primary mb-2 font-racing uppercase"></h2>
                            <div id="popup-type" class="text-gray-400"></div>
                            <div class="buttons">
                                <a id="popup-itineraire" class="btn btn-sm btn-primary btn-outline" href="#" target="_blank">
                                    <x-icon name="fas-location-arrow" class="h-4 w-4 inline"></x-icon>
                                    Itinéraire
                                </a>
                                <a id="popup-phone" class="btn btn-sm btn-primary btn-outline" href="#">
                                    <x-icon name="fas-phone" class="h-4 w-4 inline"></x-icon>
                                    Appeler
                                </a>
                                <a id="popup-mail" class="btn btn-sm btn-primary btn-outline" href="#">
                                    <x-icon name="fas-envelope" class="h-4 w-4 inline"></x-icon>
                                    Contact
                                </a>
                            </div>
                            <h3 class="text-primary text-lg">
                                Détails
                            </h3>
                            <div class="p-4 mb-4 shadow-lg rounded-lg">
                                <div class="mb-2 text-primary">
                                    Horaires
                                </div>
                                <ul id="popup-opening_hours" class="flex flex-col gap-2 text-gray-600"></ul>
                            </div>
                            <div class="p-4 mb-4 shadow-lg rounded-lg">
                                <ul class="flex flex-col gap-2">
                                    <li class="[&:not(:first-child)]:pt-2 [&:not(:first-child)]:mt-2 [&:not(:first-child)]:border-t border-gray-300">
                                        <a id="popup-phone2" href="#">
                                            <div class="mb-2 text-primary">Téléphone</div>
                                            <div id="popup-phone2num" class="text-gray-600"></div>
                                        </a>
                                    </li>
                                    <li class="[&:not(:first-child)]:pt-2 [&:not(:first-child)]:mt-2 [&:not(:first-child)]:border-t border-gray-300">
                                        <a id="popup-itineraire2" class="flex justify-between items-center" href="#" target="_blank" rel="nofollow noopener">
                                            <div>
                                                <div class="mb-2 text-primary">Adresse</div>
                                                <div id="popup-address" class="text-gray-600"></div>
                                            </div>
                                            <div>
                                                <div class="icon destination">
                                                    <x-icon name="fas-location-arrow" class="h-3 w-3 inline"></x-icon>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <h3 class="text-primary text-lg">
                                Collaborateurs
                            </h3>
                            <div class="p-4 mb-4 shadow-lg rounded-lg last:mb-0">
                                <ul id="popup-employees">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
