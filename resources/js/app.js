import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

if (response.ok && result.success) {
    this.userList.push(result.data); 
    this.openModal = false;
}