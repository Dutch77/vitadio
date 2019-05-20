import {isUndefined} from 'underscore'
import {stringify} from 'qs'

export function stringifyURL(url: string, parameters: object): string {
    if (isUndefined(parameters)) {
        url = `${url}?${stringify(parameters)}`
    }
    return url
}