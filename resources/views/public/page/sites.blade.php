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

            map.on('popupclose', function(e) {
                document.querySelectorAll('.leaflet-marker-icon').forEach(function(el) {
                    el.classList.remove('leaflet-marker-clicked');
                });
            });

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
                    <span class="color" style="background:#3498db"></span>
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





<div id="popup-21" class="map-popup simplebar-scrollable-y" data-simplebar="init">
    <div class="simplebar-wrapper" style="margin: -16px;">
        <div class="simplebar-mask">
            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto;">
                    <div class="simplebar-content" style="padding: 16px;">
                        <div class="bar" style="background-color:#feba00"></div>
                        <h2 class="text-2xl text-primary mb-2">
                            Les hays
                        </h2>
                        <div class="type">Silos de collecte</div>
                        <div class="buttons">
                            <a class="btn btn-sm btn-primary btn-outline" href="http://maps.google.com/?q=Les hays, 13 Route du Moulin, 39120 Les Hays, France, 39120 Les Hays" target="_blank" rel="nofollow noopener">
                                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="13.25" height="13.25" viewBox="0 0 13.25 13.25">
                                    <g>
                                        <path d="M6.969 3.96a.667.667 0 00-.48 1.129l.862.862H4.294a.667.667 0 000 1.333h3.057l-.862.862-.017.017a.667.667 0 00.96.925l2-2a.668.668 0 000-.943l-2-2a.664.664 0 00-.463-.185"></path>
                                        <path d="M6.627 1.333a.4.4 0 01.288.119L11.8 6.34a.407.407 0 010 .576L6.915 11.8a.407.407 0 01-.576 0L1.453 6.915a.407.407 0 010-.576L6.34 1.453a.4.4 0 01.288-.119m0-1.334A1.733 1.733 0 005.4.511L.51 5.395a1.741 1.741 0 000 2.462L5.4 12.74a1.739 1.739 0 002.461 0l4.879-4.883a1.741 1.741 0 000-2.462L7.857.51A1.733 1.733 0 006.626 0"></path>
                                    </g>
                                </svg>
                                Itinéraire
                            </a>
                            <a class="btn btn-sm btn-primary btn-outline" href="tel:03 84 81 41 94">
                                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="19.998" height="19.999" viewBox="0 0 19.998 19.999">
                                    <path d="M19.932 14.558a3.812 3.812 0 00-.086-.381 1.976 1.976 0 00-1.585-1.392l-4.331-.721a2.014 2.014 0 00-1.905.729c-.058.073-.114.149-.226.273a9.088 9.088 0 01-4.831-4.92c.1-.069.2-.143.3-.22a2.013 2.013 0 00.721-1.877l-.671-4.255A1.985 1.985 0 005.982.206 3.918 3.918 0 005.44.069a4.54 4.54 0 00-3.764 1.043A4.778 4.778 0 00.006 4.88 15.542 15.542 0 0015.118 20h.13a4.77 4.77 0 003.618-1.661 4.569 4.569 0 001.066-3.781zm-2.579 2.472a2.77 2.77 0 01-2.182.969A13.543 13.543 0 011.999 4.827a2.789 2.789 0 01.975-2.2 2.528 2.528 0 011.657-.632 2.6 2.6 0 01.447.04 1.722 1.722 0 01.259.067l.666 4.269c-.05.04-.1.078-.158.116a2.027 2.027 0 00-.75 2.5 11.352 11.352 0 005.9 5.905 2.03 2.03 0 002.507-.749l.093-.115 4.32.681a1.84 1.84 0 01.041.184 2.571 2.571 0 01-.603 2.137z"></path>
                                </svg>
                                Appeler
                            </a>
                            <a class="btn btn-sm btn-primary btn-outline" href="mailto:lisa.hays@terrecomtoise.com">
                                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16">
                                    <path d="M15 0H5a5.006 5.006 0 00-5 5v6a5.006 5.006 0 005 5h10a5.006 5.006 0 005-5V5a5.006 5.006 0 00-5-5zM5 2h10s2.189.688 2.68 1.678l-6.016 4.01a2.992 2.992 0 01-3.328 0L2.32 3.678A2.994 2.994 0 015 2zm10 12H5a3 3 0 01-3-3V5.868l5.226 3.484a4.984 4.984 0 005.547 0L18 5.868V11a3 3 0 01-3 3z"></path>
                                </svg>
                                Contact
                            </a>
                        </div>
                        <h3 class="h6">Détails</h3>
                        <div class="group schedules">
                            <ul>
                                <li class="item">
                                    <a href="javascript:void(0);" onclick="displayDays(event)">
                                        <div class="label flex">
                                            <div class="left">Horaires</div>
                                            <div class="right"><svg fill="currentColor" stroke="currentcolor" xmlns="http://www.w3.org/2000/svg" width="7.717" height="4.717" viewBox="0 0 7.717 4.717">
                                                    <path d="M7.12 1.119l-3 3a.333.333 0 01-.471 0l-3-3A.333.333 0 011.12.648l2.764 2.764L6.648.648a.333.333 0 11.471.471z"></path>
                                                </svg></div>
                                        </div>
                                        <div class="value">
                                            <table>
                                                <tbody>
                                                <tr class="day-1 hide">
                                                    <td class="text-left">Lundi</td>
                                                    <td class="text-right">09:00-12:00</td>
                                                    <td class="text-right">13:30-17:00</td>
                                                </tr>
                                                <tr class="day-2 hide">
                                                    <td class="text-left">Mardi</td>
                                                    <td class="text-right">09:00-12:00</td>
                                                    <td class="text-right">13:30-17:00</td>
                                                </tr>
                                                <tr class="day-3 hide">
                                                    <td class="text-left">Mercredi</td>
                                                    <td class="text-right">09:00-12:00</td>
                                                    <td class="text-right">13:30-17:00</td>
                                                </tr>
                                                <tr class="day-4 hide">
                                                    <td class="text-left">Jeudi</td>
                                                    <td class="text-right">09:00-12:00</td>
                                                    <td class="text-right">13:30-17:00</td>
                                                </tr>
                                                <tr class="day-5 active">
                                                    <td class="text-left">Vendredi</td>
                                                    <td class="text-right">09:00-12:00</td>
                                                    <td class="text-right">13:30-17:00</td>
                                                </tr>
                                                <tr class="day-6 hide">
                                                    <td class="text-left">Samedi</td>
                                                    <td class="text-right" colspan="2">Fermé</td>
                                                </tr>
                                                <tr class="day-7 hide">
                                                    <td class="text-left">Dimanche</td>
                                                    <td class="text-right" colspan="2">Fermé</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="info">
                                            <span class="open">Ouvert</span>
                                            <span class="next">(Ferme dans 2 heures)</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="group">
                            <ul>
                                <li class="item">
                                    <a href="tel:03 84 81 41 94">
                                        <div class="label">Téléphone</div>
                                        <div class="value">03 84 81 41 94</div>
                                    </a>
                                </li>
                                <li class="item">
                                    <a class="flex" href="http://maps.google.com/?q=Les hays, 13 Route du Moulin, 39120 Les Hays, France, 39120 Les Hays" target="_blank" rel="nofollow noopener">
                                        <div class="left">
                                            <div class="label">Adresse</div>
                                            <div class="value">13 Route du Moulin, 39120 Les Hays, France</div>
                                        </div>
                                        <div class="right">
                                            <div class="icon destination"><svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="13.25" height="13.25" viewBox="0 0 13.25 13.25">
                                                    <g>
                                                        <path d="M6.969 3.96a.667.667 0 00-.48 1.129l.862.862H4.294a.667.667 0 000 1.333h3.057l-.862.862-.017.017a.667.667 0 00.96.925l2-2a.668.668 0 000-.943l-2-2a.664.664 0 00-.463-.185"></path>
                                                        <path d="M6.627 1.333a.4.4 0 01.288.119L11.8 6.34a.407.407 0 010 .576L6.915 11.8a.407.407 0 01-.576 0L1.453 6.915a.407.407 0 010-.576L6.34 1.453a.4.4 0 01.288-.119m0-1.334A1.733 1.733 0 005.4.511L.51 5.395a1.741 1.741 0 000 2.462L5.4 12.74a1.739 1.739 0 002.461 0l4.879-4.883a1.741 1.741 0 000-2.462L7.857.51A1.733 1.733 0 006.626 0"></path>
                                                    </g>
                                                </svg></div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <h3 class="text-xl">
                            Personnels
                        </h3>
                        <div class="group commerciaux">
                            <ul>
                                <li class="item">
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
                                <li class="item">
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
                                <li class="item">
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
