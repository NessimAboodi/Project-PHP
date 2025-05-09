package org.example;

public class Loueur {
    private String id;
    private String nom;
    private int nbAppelsKO;
    private int nbTimeouts;

    public Loueur(String id, String nom) {
        this.id = id;
        this.nom = nom;
        this.nbAppelsKO = 0;
        this.nbTimeouts = 0;
    }

    // Getters et setters
    public String getId() {
        return id;
    }

    public String getNom() {
        return nom;
    }

    public int getNbAppelsKO() {
        return nbAppelsKO;
    }

    public int getNbTimeouts() {
        return nbTimeouts;
    }

    public void incrementAppelsKO() {
        this.nbAppelsKO++;
    }

    public void incrementTimeouts() {
        this.nbTimeouts++;
    }

    @Override
    public String toString() {
        return "Loueur{" +
                "id='" + id + '\'' +
                ", nom='" + nom + '\'' +
                ", nbAppelsKO=" + nbAppelsKO +
                ", nbTimeouts=" + nbTimeouts +
                '}';
    }
}
