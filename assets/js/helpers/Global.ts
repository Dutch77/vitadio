import BaseGlobal = NodeJS.Global
export interface Global extends BaseGlobal {
    $: JQueryStatic
    jQuery: JQueryStatic
}