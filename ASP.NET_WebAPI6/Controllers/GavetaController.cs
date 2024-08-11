using ControleEstoque.DTO;
using ControleEstoque.Entities;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.ModelBinding;
using Microsoft.EntityFrameworkCore;
using System.Net;

namespace ControleEstoque.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    public class GavetaController : ControllerBase
    {
        private readonly DBContext DBContext;

        public GavetaController(DBContext DBContext)
        {
            this.DBContext = DBContext;
        }

        [HttpGet("GetGaveta")]
        public async Task<ActionResult<List<GavetaDTO>>> Get()
        {
            var List = await DBContext.Gaveta.Select(
                s => new GavetaDTO
                {
                    Id = s.Id,
                    Nome = s.Nome,
                    Codigo = s.Codigo,
                    Gondola = new GondolaDTO()
                    {
                        Id = s.Gondola.Id,
                        Nome = s.Gondola.Nome,
                        Codigo = s.Gondola.Codigo,
                    }
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

        [HttpGet("GetGavetaById")]
        public async Task<ActionResult<GavetaDTO>> GetUserById(int Id)
        {
            GavetaDTO gaveta = await DBContext.Gaveta.Select(
                    s => new GavetaDTO
                    {
                        Id = s.Id,
                        Nome = s.Nome,
                        Codigo = s.Codigo,
                        Gondola = new GondolaDTO()
                        {
                            Id = s.Gondola.Id,
                            Nome = s.Gondola.Nome,
                            Codigo = s.Gondola.Codigo,
                        }
                    })
                .FirstOrDefaultAsync(s => s.Id == Id);

            if (gaveta == null)
            {
                return NotFound();
            }
            else
            {
                return gaveta;
            }
        }

        [HttpPost("InsertGaveta")]
        public HttpStatusCode InsertGaveta(GavetaDTO gaveta)
        {
            var entity = new Gaveta()
            {
                Id = gaveta.Id,
                Nome = gaveta.Nome,
                Codigo = gaveta.Codigo,
                GondolaId = gaveta.Gondola.Id,
                
            };

            DBContext.Gaveta.Add(entity);
            DBContext.SaveChangesAsync();

            return HttpStatusCode.Created;
        }

        [HttpPut("UpdateGaveta")]
        public async Task<HttpStatusCode> UpdateGaveta(GavetaDTO gaveta)
        {
            var entity = await DBContext.Gaveta.FirstOrDefaultAsync(s => s.Id == gaveta.Id);

            entity.Id = gaveta.Id;
            entity.Nome = gaveta.Nome;
            entity.Codigo = gaveta.Codigo;
            entity.GondolaId = gaveta.Gondola.Id;

            await DBContext.SaveChangesAsync();
            return HttpStatusCode.OK;
        }

        [HttpDelete("DeleteGaveta/{Id}")]
        public async Task<HttpStatusCode> DeleteGaveta(int Id)
        {
            var entity = new Gaveta()
            {
                Id = Id
            };
            DBContext.Gaveta.Attach(entity);
            DBContext.Gaveta.Remove(entity);
            await DBContext.SaveChangesAsync();
            return HttpStatusCode.OK;
        }
    }
}
