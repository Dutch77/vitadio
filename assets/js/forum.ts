    // Typescript test with babel
//
// import * as _ from 'underscore'
//
// function timeoutPromise (time: number): Promise<boolean> {
//     return new Promise((resolve) => {
//         setTimeout(() => {
//             resolve(_.isArray([]))
//         }, time)
//     })
// }
//
// timeoutPromise(1000)
//     .then((isArray: boolean) => {
//         // do something
//     })

require('../scss/homepage.scss');
$('body').addClass('homepage')
console.log('homepage javascript loaded')