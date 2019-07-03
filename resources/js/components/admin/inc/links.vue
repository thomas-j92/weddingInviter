<template>
	<div>
	<!-- <b-nav vertical class="w-25">
		<b-nav-item to="/admin/dashboard">Dashboard</b-nav-item>
		<b-nav-item to="/admin/guests">Guests</b-nav-item>
		<b-nav-item to="/admin/reports">Reports</b-nav-item>
		<b-nav-item to="/admin/emails">Emails</b-nav-item>
	</b-nav> -->

	<sidebar-menu :menu="menu" />
</div>
</template>

<script>
	export default {
		name: 'admin.links',
		data() {
			return {
                menu: [
                    {
                        header: true,
                        title: 'Main Navigation',
                        // component: componentName
                        // visibleOnCollapse: true
                        // class: ''
                        // attributes: {}
                    },
                    {
                        href: '/admin/dashboard',
                        title: 'Dashboard',
                        icon: 'fa fa-th-list',
                        /* 
                        // custom icon
                        icon: {
                            element: 'span',
                            class: 'fa fa-user',
                            attributes: {}
                        }
                        */
                        // disabled: true
                        // class: ''
                        // attributes: {}
                        // alias: '/path'
                        /*
                        badge: {
                            text: 'new',
                            class: 'default-badge'
                            // attributes: {}
                            // element: 'span'
                        }
                        */
                    },
                    {
                        href: '/admin/guests',
                        title: 'Guests',
                        icon: 'fa fa-users',
                    },
                    {
                        href: '/admin/reports',
                        title: 'Reports',
                        icon: 'fa fa-chart-pie',
                    },
                    {
                        href: '/admin/emails',
                        title: 'Emails',
                        icon: 'fa fa-envelope',
                    }
                ]
			}
		}
	}
</script>