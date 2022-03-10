beforeEach(() => {
    cy.refreshDatabase();
});

describe('Create Order', () => {
    it('can create a order', () => {
        // Arrange
        cy.create('App\\Models\\Menu')

        // Act
        cy.visit('/')
        cy.get('.addOrder').click()
        cy.contains('Ver Pedido').click()
        cy.get('#client_name').type('Miguel Bonifaz')
        cy.get('#table_number').select('2')
        cy.contains('button', 'Confirmar Pedido').click()

        // Assert
        cy.get('body').should('contain', 'Su pedido se realizó con éxito')
    })
})