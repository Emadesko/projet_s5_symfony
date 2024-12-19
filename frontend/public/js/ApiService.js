export default class ApiService {
  constructor() {
    this.baseURL = "http://127.0.0.1:8000/";
  }

  async getElements(endpoint) {
      const response = await fetch(`${this.baseURL}${endpoint}`) 
      return await response.json();
  }

  async postData(endpoint, donnees) {
    try {
      const response = await fetch(`${this.baseURL}${endpoint}`, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
          },
          body: JSON.stringify(donnees),
      });

      if (!response.ok) {
          throw new Error(`Erreur : ${response.status}`);
      }

      const resultat = await response.json();
      console.log('Réponse du serveur :', resultat);
      return resultat; // Retourne la réponse JSON
    } catch (erreur) {
        console.error('Erreur lors de l\'envoi des données :', erreur);
        throw erreur; // Propagation de l'erreur
    }
  }
}

