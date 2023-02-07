const createNavMenu = (data) => {
    let temp = []
    let newNavItems = []
    data.map((m) => temp.push(m.module.title))
    temp = [...new Set(temp)];
    temp.map((m,index) => {
        newNavItems.push({
                id: index,
                title: m,
                value: m.toLowerCase(),
                path: `/${m.toLowerCase()}`
            })
    })
    return newNavItems
}

export default createNavMenu