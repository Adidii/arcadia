import { initializeApp } from "firebase/app";
import { getFirestore, collection, addDoc, getDocs } from "firebase/firestore";

// Configuration Firebase pour ton projet
const firebaseConfig = {
  apiKey: "AIzaSyBL8ciO-hSoIxDlzA1gAPifSlO1AL6o2vk",
  authDomain: "zoo1-52a5e.firebaseapp.com",
  projectId: "zoo1-52a5e",
  storageBucket: "zoo1-52a5e.appspot.com",
  messagingSenderId: "928703569027",
  appId: "1:928703569027:web:5e20016efcde27a7d10fb6"
};

// Initialisation de Firebase
const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

// Fonction pour ajouter un avis
export async function addReview(review) {
  try {
    const docRef = await addDoc(collection(db, "reviews"), review);
    console.log("Avis ajouté avec l'ID : ", docRef.id);
  } catch (e) {
    console.error("Erreur lors de l'ajout de l'avis : ", e);
  }
}

// Fonction pour récupérer les avis
export async function getReviews() {
  try {
    const querySnapshot = await getDocs(collection(db, "reviews"));
    const reviews = [];
    querySnapshot.forEach((doc) => {
      reviews.push(doc.data());  // Assure-toi que tu récupères les données ici
    });
    return reviews;
  } catch (e) {
    console.error("Erreur lors de la récupération des avis : ", e);
    return [];
  }
}
