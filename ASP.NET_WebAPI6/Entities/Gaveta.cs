namespace ControleEstoque.Entities
{
    public partial class Gaveta
    {
        public int Id { get; set; }

        public string Nome { get; set; }

        public string Codigo { get; set; }

        public int GondolaId { get; set; }

        public virtual Gondola Gondola { get; set; }
    }
}
