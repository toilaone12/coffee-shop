importScripts('https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js')
importScripts('https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js')
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyAjiindd25wlTFOvf62iYcVvtc2O82J1bY",
    authDomain: "send-notification-coffee.firebaseapp.com",
    projectId: "send-notification-coffee",
    storageBucket: "send-notification-coffee.appspot.com",
    messagingSenderId: "556052948319",
    appId: "1:556052948319:web:30dcd91128987b14cbc2ea",
    measurementId: "G-BBB3JG6YQ0"
};
const app = firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
messaging.onBackgroundMessage(function(payload){
    const title = payload.data.title;
    console.log(payload.data.click_action);
    const option = {
      body: payload.data.body,
      icon: payload.data.icon,
      image: payload.data.image
    }
    // console.log(self);
    self.registration.showNotification(title, option)
    self.addEventListener('notificationclick', function (e){
      const click = e.notification;
      click.close();
      e.waitUntil(
        clients.openWindow(payload.data.click_action)
      )
    })
});
