import store from '../store/index.js'

const modulePermission = (data) => {
    if(data.includes('id')) {
        data = data.split('-')[0]
    }
    return store.state.permission.length > 0 
            ? store.state.permission.filter(f => f.module.title === data).map(m => m.title.toUpperCase())
            : []
}

export default modulePermission