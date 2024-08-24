using ControleEstoque.DTO;
using ControleEstoque.Entities;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using System.Net;

namespace ControleEstoque.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    public class GondolaController : ControllerBase
    {
        private readonly DBContext DBContext;

        public GondolaController(DBContext DBContext)
        {
            this.DBContext = DBContext;
        }

        [HttpGet("GetGondola")]
        public async Task<ActionResult<List<GondolaDTO>>> Get()
        {
            var List = await DBContext.Gondola.Select(
                s => new GondolaDTO
                {
                    Id = s.Id,
                    Nome = s.Nome,
                    Codigo = s.Codigo,
                }
            ).ToListAsync();

            if (List.Count < 0)
            {
                return NotFound();
            }
            else
            {
                return List;
            }
        }

        [HttpGet("GetGondolaById/{id}")]
        public async Task<ActionResult<GondolaDTO>> GetUserById(int Id)
        {
            GondolaDTO gondola = await DBContext.Gondola.Select(
                    s => new GondolaDTO
                    {
                        Id = s.Id,
                        Nome = s.Nome,
                        Codigo = s.Codigo,
                    })
                .FirstOrDefaultAsync(s => s.Id == Id);

            if (gondola == null)
            {
                return NotFound();
            }
            else
            {
                return gondola;
            }
        }

        [HttpPost("InsertGondola")]
        public async Task<HttpStatusCode> InsertGondola(GondolaDTO gondola)
        {
            var entity = new Gondola()
            {
                Id = gondola.Id,
                Nome = gondola.Nome,
                Codigo = gondola.Codigo,
            };

            DBContext.Gondola.Add(entity);
            await DBContext.SaveChangesAsync();

            return HttpStatusCode.Created;
        }

        [HttpPut("UpdateGondola")]
        public async Task<HttpStatusCode> UpdateGondola(GondolaDTO gondola)
        {
            var entity = await DBContext.Gondola.FirstOrDefaultAsync(s => s.Id == gondola.Id);

            entity.Id = gondola.Id;
            entity.Nome = gondola.Nome;
            entity.Codigo = gondola.Codigo;

            await DBContext.SaveChangesAsync();
            return HttpStatusCode.OK;
        }

        [HttpDelete("DeleteGondola/{Id}")]
        public async Task<HttpStatusCode> DeleteGondola(int Id)
        {
            var entity = new Gondola()
            {
                Id = Id
            };
            DBContext.Gondola.Attach(entity);
            DBContext.Gondola.Remove(entity);
            await DBContext.SaveChangesAsync();
            return HttpStatusCode.OK;
        }
    }
}
