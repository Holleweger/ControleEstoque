namespace ControleEstoque.Entities
{
    public partial class Gaveta
    {
        public virtual int Id { get; set; }

        public virtual string Nome { get; set; }

        public virtual string Codigo { get; set; }

        public virtual int GondolaId { get; set; }

        public virtual Gondola Gondola { get; set; }
    }
}
