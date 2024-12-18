export default class ApiService {
    constructor() {
      this.baseURL = "http://127.0.0.1:8000/";
    }
  
    async getElements(endpoint) {
        try {
          const response = await fetch(`${this.baseURL}${endpoint}`);
          return await response.json();
        } catch (error) {
            console.error('Erreur lors de la récupération des données :', error);
        }
    }

    // Méthode pour envoyer des données vers l'API (POST)
    async postData(endpoint, body) {
      try {
        // Faire une requête POST à l'API
        const response = await fetch(`${this.baseURL}${endpoint}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(body),
        });
  
        // Vérifier si la réponse est correcte
        if (!response.ok) {
          throw new Error('Erreur lors de l\'envoi des données');
        }
  
        // Extraire les données JSON de la réponse
        const data = await response.json();
        return data;
      } catch (error) {
        console.error('Erreur:', error);
        throw error;
      }
    }
  }
  
  