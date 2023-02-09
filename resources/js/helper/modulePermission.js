import store from '../store/index.js'

const modulePermission = (data) => {
    return store.state.permission.filter(f => f.module.title === data).map(m => m.title)
}

export default modulePermission