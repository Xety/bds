import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: ['class', '[data-theme="dark"]'],
    content: [
        "./app/**/*.php",
        "./config/*.php",
        './resources/views/**/*.blade.php',
        "./resources/js/**/*.js",
        "./resources/js/Components/**/*.vue",
        './storage/framework/views/*.php',
        //'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',

        // Add mary
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
    ],

    theme: {
        extend: {
            fontFamily: {
                'bds': ['Myriad Pro Regular'],
                'racing': ['Racing Sans One'],
            },
            animation: {
                'ringing': 'ringing 2s ease 1s infinite'
              },
              keyframes: {
                ringing: {
                    '0%': {transform:"rotate(-15deg)"},
                    '2%': {transform:'rotate(15deg)'},
                    '4%, 12%': {transform:'rotate(-18deg)'},
                    '6%, 14%': {transform:'rotate(18deg)'},
                    '8%': {transform:'rotate(-22deg)'},
                    '10%': {transform:'rotate(22deg)'},
                    '16%': {transform:'rotate(-12deg)'},
                    '18%': {transform:'rotate(12deg)'},
                    '20%': {transform:'rotate(0deg)'}
                }
            }
        },
        container: {
            center: true
        }
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require("daisyui")
    ],

    daisyui: {
        themes: [
            {
                light: {
                    ...require("daisyui/src/theming/themes")["[data-theme=light]"],
                    // Primary
                    "primary": "#2e73b9",
                    "primary-focus": "#23568b",
                    "primary-content": "#ffffff",

                    "--rounded-box": "0.375rem",
                    "--rounded-btn": "0.25rem",
                    "--bc": "215 19% 35%",
                }
            },
            {
                dark: {
                    ...require("daisyui/src/theming/themes")["[data-theme=dark]"],
                    // Primary
                    "primary": "#2e73b9",
                    "primary-focus": "#23568b",
                    "primary-content": "#ffffff",

                    "--rounded-box": "0.375rem",
                    "--rounded-btn": "0.25rem",
                    "--bc": "213 27% 84%",
                }
            }
        ],
    },

    // BYPASS TO COMPILE FULL CLASSES FOR DEV
    /*safelist: [
        {
          pattern: /./,
        }
    ],*/
};
