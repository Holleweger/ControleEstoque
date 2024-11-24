using Microsoft.EntityFrameworkCore;

namespace ControleEstoque.Entities
{
    public partial class DBContext : DbContext
    {
        public DBContext()
        {
        }

        public DBContext(DbContextOptions<DBContext> options)
            : base(options)
        {
        }

        public virtual DbSet<Gondola> Gondola { get; set; }
        public virtual DbSet<Gaveta> Gaveta { get; set; }
        public virtual DbSet<Produto> Produto { get; set; }
        public virtual DbSet<Produto_Gaveta> Produto_Gaveta { get; set; }
        public virtual DbSet<Usuario> Usuario { get; set; }

        protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
        {
            if (!optionsBuilder.IsConfigured)
            {
                optionsBuilder.UseMySQL("server=localhost;port=3306;user=root;password=1234;database=controleestoque");
            }
        }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<Gondola>();

            modelBuilder.Entity<Gaveta>();

            modelBuilder.Entity<Produto>();

            modelBuilder.Entity<Produto_Gaveta>()
                .Property(t => t.ProdutoId).HasColumnName("ProdutoId");

            modelBuilder.Entity<Produto_Gaveta>()
                .Property(t => t.GavetaId).HasColumnName("GavetaId");

            modelBuilder.Entity<Usuario>();

            OnModelCreatingPartial(modelBuilder);
        }

        partial void OnModelCreatingPartial(ModelBuilder modelBuilder);

    }
}
