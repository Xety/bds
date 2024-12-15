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
            const sites = {
                "siege-social" : {
                    1: {
                        id : 1,
                        name : "Siège Social",
                        type : "Siège Social",
                        coordinates : "46.890320, 5.028053",
                        phone : "03 85 91 93 00",
                        email : "siege@bourgognedusud.coop",
                        address : "6 Avenue du président Borgeot, 71350 Verdun-sur-le-Doubs",
                        opening_hours : [
                            {
                                monday : 'Lundi : 08:00 12:30 - 13:30 18:00',
                                tuesday : 'Mardi : 08:00 12:30 - 13:30 18:00',
                                wednesday : 'Mercredi : 08:00 12:30 - 13:30 18:00',
                                thursday : 'Jeudi : 08:00 12:30 - 13:30 18:00',
                                friday : 'Vendredi : 08:00 12:30 - 13:30 18:00',
                                saturday : 'Fermé',
                                sunday : 'Fermé'
                            }
                        ],
                        employees : [
                            {
                                name : 'Bertrand Combemorel',
                                function : "Directeur Général",
                                email : "b.combemorel@bourgognedusud.coop",
                                phone : "06 12 34 56 78"
                            },
                            {
                                name : 'Yann Joly',
                                function : "Directeur Général Délégué",
                                email : "y.joly@bourgognedusud.coop",
                                phone : "06 12 34 56 78"
                            }
                        ]
                    }
                }
            };

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


            const groups = [];


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
            let marker = L.marker([46.890320, 5.028053], {icon: icons[1]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 21);
            });
            group.push(marker);

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
            // GV BEAUNE
            marker = L.marker([47.020127, 4.858570], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV BLANZY
            marker = L.marker([46.705543, 4.410957], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV BLIGNY SUR OUCHE
            marker = L.marker([47.107600, 4.658938], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV BUXY
            marker = L.marker([46.716038, 4.704890], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV CHAGNY
            marker = L.marker([46.907061, 4.763383], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV CLUNY
            marker = L.marker([46.422058, 4.664506], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV MONTPONT EN BRESSE
            marker = L.marker([46.549644, 5.161850], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV NOLAY
            marker = L.marker([46.947904, 4.642818], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV PIERRE DE BRESSE
            marker = L.marker([46.881663, 5.260933], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV ROMENAY
            marker = L.marker([46.502323, 5.058676], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV SEURRE
            marker = L.marker([46.989348, 5.147728], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV SAINT GENGOUX LE NATIONAL
            marker = L.marker([46.611321, 4.661913], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV SAINT GERMAIN DU PLAIN
            marker = L.marker([46.706006, 5.002776], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV SAINT LEGER SUR DHEUNE
            marker = L.marker([46.855921, 4.641632], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV SAINT MARCEL
            marker = L.marker([46.778775, 4.894535], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV TOURNUS
            marker = L.marker([46.573665, 4.904457], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

            // GV VERDUN SUR LE DOUBS
            marker = L.marker([46.892028, 5.024346], {icon: icons[2]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 43);
            });
            group.push(marker);

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

            // SILO BEAUNE
            marker = L.marker([47.019326, 4.864878], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO BLIGNY SUR OUCHE
            marker = L.marker([47.107465, 4.659509], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO BRANGES
            marker = L.marker([46.655116, 5.191087], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO CHALON NORD
            marker = L.marker([46.802799, 4.869835], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO CHALON SUD
            marker = L.marker([46.758015, 4.870060], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO CRISSEY
            marker = L.marker([46.815198, 4.863918], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO GERGY
            marker = L.marker([46.897208, 4.947286], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO JULLY LES BUXY
            marker = L.marker([46.702876, 4.720747], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO L'ABERGEMENT LES SEURRE
            marker = L.marker([47.006151, 5.064483], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO LAYS SUR LE DOUBS
            marker = L.marker([47.006151, 5.064483], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO LESSARD EN BRESSE
            marker = L.marker([47.006151, 5.064483], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO MERVANS
            marker = L.marker([46.815730, 5.172723], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO MEURSANGES
            marker = L.marker([46.988124, 4.949231], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO MONTPONT EN BRESSE
            marker = L.marker([46.549734, 5.161107], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO NOLAY
            marker = L.marker([46.948494, 4.643295], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO PIERRE DE BRESSE
            marker = L.marker([46.872152, 5.276704], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO ROMENAY
            marker = L.marker([46.501882, 5.058965], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO SENNECEY LE GRAND
            marker = L.marker([46.642214, 4.875473], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO SEURRE
            marker = L.marker([46.995644, 5.150008], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO SIMANDRE
            marker = L.marker([46.615337, 4.992433], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO SIMARD
            marker = L.marker([46.724197, 5.189868], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO SAINT GENGOUX LE NATIONAL
            marker = L.marker([46.604934, 4.669431], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO SAINT GERMAIN DU PLAIN
            marker = L.marker([46.705789, 5.002355], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO SAINT LEGER SUR DHEUNE
            marker = L.marker([46.856176, 4.641547], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO SAINT MARTIN EN BRESSE
            marker = L.marker([46.815712, 5.068114], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO TOURNUS
            marker = L.marker([46.552958, 4.910878], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO TRONCHY
            marker = L.marker([46.733599, 5.077143], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

            // SILO VERDUN SUR LE DOUBS
            marker = L.marker([46.891040, 5.028434], {icon: icons[3]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 46);
            });
            group.push(marker);

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

            //  USINE EXTRUSEL
            marker = L.marker([46.801969, 4.871449], {icon: icons[4]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 17);
            });
            group.push(marker);

            //  USINE MOULIN JANNET & FILS
            marker = L.marker([46.494770, 5.203094], {icon: icons[4]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 17);
            });
            group.push(marker);

            // USINE SELVAH
            marker = L.marker([46.873835, 5.061098], {icon: icons[4]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 18);
            });
            group.push(marker);

            // USINE VAL-UNION
            marker = L.marker([46.875712, 5.060862], {icon: icons[4]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 18);
            });
            group.push(marker);

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

            //  FICHET
            marker = L.marker([46.967943, 4.795307], {icon: icons[5]});
            marker.addTo(map);
            marker.on('click', function(e) {
                clickMarker(e.target, 17);
            });
            group.push(marker);

            groups['activite-vigne'] = new L.FeatureGroup(group).addTo(map);
            bounds.extend(groups['activite-vigne'].getBounds());


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

                        map.addLayer(groups['activite-vigne']);
                        bounds.extend(groups['activite-vigne'].getBounds());

                        map.flyToBounds(bounds, { padding: [100, 100]});
                    }
                });
            });

            function clickMarker(target, id) {
                document.querySelectorAll('.leaflet-marker-icon').forEach(function(el) {
                    el.classList.remove('leaflet-marker-clicked');
                });
                target._icon.classList.add('leaflet-marker-clicked');

                const popup = document.getElementById('popup-21');
                L.popup().setLatLng(target._latlng).setContent(popup.outerHTML).openOn(map);

                /*oc.ajax('onClickMarker', {
                    update: {
                        'map/sites/popup': '#popup-wrapper',
                    },
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        this.success(data);
                        const popup = document.getElementById('popup-'+id);
                        L.popup().setLatLng(target._latlng).setContent(popup.outerHTML).openOn(map);
                    },
                })*/
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
                <button class="filter " data-slug="activite-vigne">
                    <span class="color" style="background:#a50343"></span>
                    <span>Activité vigne</span>
                </button>
            </li>
        </ul>
    </div>
    <button class="next"><svg stroke="currentColor" fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="7.262" height="12.385" viewBox="0 0 7.262 12.385">
            <path d="M6.595 6.595l-5.123 5.123a.569.569 0 01-.8-.8l4.721-4.721L.672 1.476a.569.569 0 01.8-.8l5.123 5.123a.569.569 0 010 .796z" />
        </svg></button>
</section>
<section id="map" class="min-h-dvh"></section>
<div id="popup-wrapper"></div>





<div id="popup-21" class="map-popup simplebar-scrollable-y">
    <div class="simplebar-wrapper" style="margin: -16px;">
        <div class="simplebar-mask">
            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                <div class="simplebar-content-wrapper"  style="height: auto;">
                    <div class="border-l-8 border-[#feba00] p-4">
                        <h2 class="text-2xl text-primary mb-2 font-racing uppercase">
                            VERDUN SUR LE DOUBS
                        </h2>
                        <div class="text-gray-400">
                            Silos de collecte
                        </div>
                        <div class="buttons">
                            <a class="btn btn-sm btn-primary btn-outline" href="http://maps.google.com/?q=Les hays, 13 Route du Moulin, 39120 Les Hays, France, 39120 Les Hays" target="_blank">
                                <x-icon name="fas-location-arrow" class="h-4 w-4 inline"></x-icon>
                                Itinéraire
                            </a>
                            <a class="btn btn-sm btn-primary btn-outline" href="tel:03 84 81 41 94">
                                <x-icon name="fas-phone" class="h-4 w-4 inline"></x-icon>
                                Appeler
                            </a>
                            <a class="btn btn-sm btn-primary btn-outline" href="mailto:lisa.hays@terrecomtoise.com">
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
                            <ul class="flex flex-col gap-2 text-gray-600">
                                <li class="flex justify-between">
                                    <div>Lundi</div>
                                    <div>08:00 12:30 - 13:30 18:00</div>
                                </li>
                                <li class="flex justify-between">
                                    <div>Mardi</div>
                                    <div>08:00 12:30 - 13:30 18:00</div>
                                </li>
                                <li class="flex justify-between">
                                    <div>Mercredi</div>
                                    <div>08:00 12:30 - 13:30 18:00</div>
                                </li>
                                <li class="flex justify-between">
                                    <div>Jeudi</div>
                                    <div>08:00 12:30 - 13:30 18:00</div>
                                </li>
                                <li class="flex justify-between">
                                    <div>Vendredi</div>
                                    <div>08:00 12:30 - 13:30 18:00</div>
                                </li>
                                <li class="flex justify-between">
                                    <div>Samedi</div>
                                    <div>Fermé</div>
                                </li>
                                <li class="flex justify-between">
                                    <div>Dimanche</div>
                                    <div>Fermé</div>
                                </li>
                            </ul>
                        </div>
                        <div class="p-4 mb-4 shadow-lg rounded-lg">
                            <ul class="flex flex-col gap-2">
                                <li class="[&:not(:first-child)]:pt-2 [&:not(:first-child)]:mt-2 [&:not(:first-child)]:border-t border-gray-300">
                                    <a href="tel:03 84 81 41 94">
                                        <div  class="mb-2 text-primary">Téléphone</div>
                                        <div class="text-gray-600">03 84 81 41 94</div>
                                    </a>
                                </li>
                                <li class="[&:not(:first-child)]:pt-2 [&:not(:first-child)]:mt-2 [&:not(:first-child)]:border-t border-gray-300">
                                    <a class="flex justify-between items-center" href="http://maps.google.com/?q=Les hays, 13 Route du Moulin, 39120 Les Hays, France, 39120 Les Hays" target="_blank" rel="nofollow noopener">
                                        <div>
                                            <div class="mb-2 text-primary">Adresse</div>
                                            <div class="text-gray-600">13 Route du Moulin, 39120 Les Hays, France</div>
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
                            <ul>
                                <li class="[&:not(:first-child)]:pt-2 [&:not(:first-child)]:mt-2 [&:not(:first-child)]:border-t border-gray-300 ">
                                    <div class="flex justify-start items-center">
                                        <div class="avatar mr-3">
                                            <div class="w-16 rounded-full bg-primary">
                                                <img class="p-2" src="{{ asset('images/logos/bds_blanc.png') }}" alt="BONNIN Eric"/>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-primary mb-2">BONNIN Eric</div>
                                            <div class="text-gray-500">Magasinier appro céréales</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="[&:not(:first-child)]:pt-2 [&:not(:first-child)]:mt-2 [&:not(:first-child)]:border-t border-gray-300">
                                    <div class="flex justify-start items-center">
                                        <div class="avatar mr-3">
                                            <div class="w-16 rounded-full bg-primary">
                                                <img class="p-2" src="{{ asset('images/logos/bds_blanc.png') }}" alt="BONNIN Eric"/>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-primary mb-2">BONNIN Eric</div>
                                            <div class="text-gray-500">Magasinier appro céréales</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="[&:not(:first-child)]:pt-2 [&:not(:first-child)]:mt-2 [&:not(:first-child)]:border-t border-gray-300">
                                    <div class="flex justify-start items-center">
                                        <div class="avatar mr-3">
                                            <div class="w-16 rounded-full bg-primary">
                                                <img class="p-2" src="{{ asset('images/logos/bds_blanc.png') }}" alt="BONNIN Eric"/>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-primary mb-2">BONNIN Eric</div>
                                            <div class="text-gray-500">Magasinier appro céréales</div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
