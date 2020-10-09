export default class Gate {
    data() {
        return {
            roles: {},
        }
    }

    constructor(user) {
        this.user = user

        axios.get('api/role')
            .then(response => {
                this.roles = response.data;
            });
    }



    isSuperAdmin() {
        return this.user.role_id === 1
    }

    isAdmin() {
        return this.user.role_id === 2
    }

    isAuthor() {
        return this.user.role_id === 3
    }

    isUser() {
        return this.user.role_id === 4
    }


    isAdminOrAuthorOrSuper() {
        if (this.user.role === 'super' || this.user.role === 'admin' || this.user.role === 'author') {
            return true;
        }
    }

    isAuthorOrUser() {
        if (this.user.type === 'author' || this.user.type === 'author') {
            return true;
        }
    }

}