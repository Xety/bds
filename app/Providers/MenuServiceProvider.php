<?php

namespace BDS\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\Facades\Menu;
use Spatie\Menu\Laravel\Link;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // Dashboard
        Menu::macro('dashboard', function () {
            return Menu::new()
                ->addClass('menu')
                ->add(
                    Link::toRoute('dashboard.index', '<i class="fa-solid fa-gauge"></i> Tableau de bord')
                        ->addClass('menu-link')
                )
                ->setActiveFromRequest()
                ->setActiveClassOnLink();
        });

        Menu::macro('cleaning', function () {
            return Menu::new()
                ->addClass('menu')
                ->add(
                    Link::toRoute('cleanings.index', '<i class="fa-solid fa-broom"></i> Gérer les Nettoyages')
                        ->addClass('menu-link')
                )
                ->setActiveFromRequest()
                ->setActiveClassOnLink();
        });

        Menu::macro('material', function () {
            return Menu::new()
                ->addClass('menu')
                ->add(
                    Link::toRoute('materials.index', '<i class="fa-solid fa-microchip"></i> Gérer les Matériels')
                        ->addClass('menu-link')
                )
                ->setActiveFromRequest()
                ->setActiveClassOnLink();
        });

        Menu::macro('zone', function () {
            return Menu::new()
                ->addClass('menu')
                ->add(
                    Link::toRoute('zones.index', '<i class="fa-solid fa-coins"></i> Gérer les Zones')
                        ->addClass('menu-link')
                )
                ->setActiveFromRequest()
                ->setActiveClassOnLink();
        });

        Menu::macro('user', function () {
            return Menu::new()
                ->addClass('menu')
                ->add(
                    Link::toRoute('users.index', '<i class="fa-solid fa-users"></i> Gérer les Utilisateurs')
                        ->addClass('menu-link')
                )
                ->setActiveFromRequest()
                ->setActiveClassOnLink();
        });

        Menu::macro('role', function () {
            return Menu::new()
                ->addClass('menu')
                ->add(
                    Link::toRoute('roles.roles.index', '<i class="fa-solid fa-user-tie"></i> Gérer les Rôles')
                        ->addClass('menu-link')
                )
                ->add(
                    Link::toRoute(
                        'roles.permissions.index',
                        '<i class="fa-solid fa-user-shield"></i> Gérer les Permissions'
                    )
                        ->addClass('menu-link')
                )
                ->setActiveFromRequest()
                ->setActiveClassOnLink();
        });

        Menu::macro('setting', function () {
            return Menu::new()
                ->addClass('menu')
                ->add(
                    Link::toRoute('settings.index', '<i class="fa-solid fa-wrench"></i> Gérer les Paramètres')
                        ->addClass('menu-link')
                )
                ->setActiveFromRequest()
                ->setActiveClassOnLink();
        });
    }
}
