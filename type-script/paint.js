class Paint {
    constructor(canvas, context,currentTool,color) {
        this.canvas = canvas;
        this.context  = context ;
        this.currentTool   = currentTool  ;
        this.color  = color ;
    }
    
    addPixel(x, y) {
        console.log("Solde: " + this.balance + " EUR");
    }
    
    deposit(amount) {
        console.log("Dépôt de " + amount + " EUR");
        this.balance += amount;
        this.showBalance();
    }
    
    withdraw(amount) {
        if (amount > this.balance) {
                 console.log("Retrait refusé !");
        } else {
            console.log("Retrait de " + amount + " EUR");
            this.balance -= amount;
            this.showBalance();
        }
    }
}