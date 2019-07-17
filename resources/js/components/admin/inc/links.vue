<template>
	<div>
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
                        href: '/admin/guests/all',
                        title: 'Guests',
                        icon: 'fa fa-users',
                        child: [
                            {
                                href: '/admin/guests/all',
                                title: 'All',
                            },
                            {
                                href: '/admin/guests/attending',
                                title: 'Attending',
                            },
                            {
                                href: '/admin/guests/not_attending',
                                title: 'Not Attending',
                            },
                            {
                                href: '/admin/guests/awaiting_reply',
                                title: 'Awaiting Reply',
                            },
                            {
                                href: '/admin/guests/not_invited',
                                title: 'Not Invited',
                            }
                        ]
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