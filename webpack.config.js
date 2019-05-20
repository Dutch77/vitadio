var Encore = require('@symfony/webpack-encore');

function resetAndConfigureEncore () {
    Encore.reset()
    Encore
        /*
         * ENTRY CONFIG
         *
         * Add 1 entry for each "page" of your app
         * (including one that's included on every page - e.g. "app")
         *
         * Each entry will result in one JavaScript file (e.g. app.js)
         * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
         */

        // admin JS/CSS


        // shared global JS/CSS: include app.js and app.css on every page
        // .createSharedEntry('app', './assets/js/app.ts')
        .createSharedEntry('app', './assets/js/app.ts')

        // page specific JS/CSS
        // .addEntry('homepage', './assets/js/homepage.js')
        .addEntry('homepage', './assets/js/forum.ts')

        // .addStyleEntry('hp', './assets/scss/homepage.scss')
        //.addEntry('page2', './assets/js/page2.js')
        // .addEntry('abcd', './assets/js/abcd.ts')


        /*
         * FEATURE CONFIG
         *
         * Enable & configure other features below. For a full
         * list of features, see:
         * https://symfony.com/doc/current/frontend.html#adding-more-features
         */
        .cleanupOutputBeforeBuild()
        .enableBuildNotifications()
        .enableSourceMaps(!Encore.isProduction())
        // enables hashed filenames (e.g. app.abc123.css)
        .enableVersioning(Encore.isProduction())

        // enables Sass/SCSS support
        .enableSassLoader()

        .enableVueLoader()
        // uncomment if you use TypeScript
        .enableTypeScriptLoader(options => {
            options.appendTsSuffixTo = [/\.vue$/];
        })

        // uncomment if you're having problems with a jQuery plugin
        .autoProvideVariables({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
        })
}

function setModernWeb() {
    Encore
        .setOutputPath('public/build/')
        .setPublicPath('/build')
        .configureBabel(function(babelConfig) {
            babelConfig.presets = [
                [
                    "@babel/preset-env",
                    {
                        useBuiltIns: false
                    }
                ]
            ],
                babelConfig.minified = true
        }, {})
}

function setPolyfillWeb() {
    Encore
        .setOutputPath('public/build/')
        .setPublicPath('/build')
        .configureBabel(function(babelConfig) {
            babelConfig.presets = [
                [
                    "@babel/preset-env",
                    {
                        "targets": {
                            ie: "11",
                            edge: "17",
                            firefox: "60",
                            chrome: "67",
                            safari: "11.1",
                        },
                        useBuiltIns: "usage"
                    }
                ]
            ],
                babelConfig.minified = true
        }, {})
}

resetAndConfigureEncore();
setModernWeb();
let modernConfig = Encore.getWebpackConfig();
resetAndConfigureEncore();
setPolyfillWeb();
let polyfillConfig = Encore.getWebpackConfig();

// module.exports = [modernConfig, polyfillConfig] //
module.exports = [polyfillConfig]

