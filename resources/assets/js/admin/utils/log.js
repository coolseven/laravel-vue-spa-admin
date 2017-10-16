/**
 * Created by admin on 2017/9/5.
 */
// FIXME
import config from '../config'

const log = () => {
    config.debug && console.log( Array.prototype.slice.call(arguments) );
}

const info = () => {
    config.debug && console.info( Array.prototype.slice.call(arguments) );
}

const error = () => {
    config.debug && console.error( Array.prototype.slice.call(arguments) );
}

const warn = () => {
    config.debug && console.warn( Array.prototype.slice.call(arguments) );
}

export default {
    log , info , error , warn
}

