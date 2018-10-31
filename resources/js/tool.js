Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'nova-mysql',
            path: '/nova-mysql',
            component: require('./components/Tool'),
        },
    ])
})
