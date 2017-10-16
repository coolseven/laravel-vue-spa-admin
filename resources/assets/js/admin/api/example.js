import http from '../http'

const ping = () => {
    let reply = http.get('/api/ping')
    return Promise.resolve(reply)
}

export default {
    ping
}
