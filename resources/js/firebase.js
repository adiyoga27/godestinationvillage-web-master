import { initializeApp } from "firebase/app";
import { getFirestore, doc, setDoc, getDoc } from "firebase/firestore";
import { getDatabase, ref, set, get as getRtdb } from "firebase/database";

const firebaseConfig = {
  apiKey: "AIzaSyAAsA-7EEY84ihoRQGWA1ZA31ixuzv1A-o",
  authDomain: "godevi-77a73.firebaseapp.com",
  projectId: "godevi-77a73",
  storageBucket: "godevi-77a73.firebasestorage.app",
  messagingSenderId: "372015866202",
  appId: "1:372015866202:web:bb08e8804469ad48531363",
  measurementId: "G-EE197QLDX3"
};

const firebaseApp = initializeApp(firebaseConfig);
const firestore = getFirestore(firebaseApp);
const realtimeDb = getDatabase(firebaseApp);

export { firebaseApp, firestore, realtimeDb };

export async function setFirestoreDoc(collection, id, data) {
  await setDoc(doc(firestore, collection, id), data);
}

export async function getFirestoreDoc(collection, id) {
  const snapshot = await getDoc(doc(firestore, collection, id));
  return snapshot.exists() ? snapshot.data() : null;
}

export async function setRealtime(path, value) {
  await set(ref(realtimeDb, path), value);
}

export async function getRealtime(path) {
  const snap = await getRtdb(ref(realtimeDb, path));
  return snap.exists() ? snap.val() : null;
}

// Usage examples (import these helpers where needed):
// import { setFirestoreDoc, getFirestoreDoc, setRealtime, getRealtime } from './firebase'