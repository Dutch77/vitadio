import {Global} from './helpers/Global'
import {init as initForum} from './forum/main'

declare const global: Global;
global.$ = global.jQuery = $;

require('../scss/app.scss');


jQuery(() => {
    initForum()
});
