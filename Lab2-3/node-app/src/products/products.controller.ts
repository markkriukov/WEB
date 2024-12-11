import {Body, Controller, Delete, Get, NotFoundException, Post, Query, Req, Param} from '@nestjs/common';
import {Pagination} from "nestjs-typeorm-paginate";
import {Product} from "./products.entity";
import {ProductsService} from "./products.service";
import { Request } from 'express';


@Controller('products')
export class ProductsController {
    constructor(private readonly productsService: ProductsService) {}
    @Get('')
    index(@Query('page') page = 1,  @Query('limit') limit = 10): Promise<Pagination<Product>> {
        return this.productsService.paginate({limit:limit, page:  page});
    }

    @Get(':id')
    show(@Param('id') id: number): Promise<Product | null> {
        return this.productsService.findOne(id);
    }

    @Post('')
    store(@Body() categoryData: Product ): Promise<Product> {
        return this.productsService.create(categoryData);
    }
    
    @Delete(':id')
    delete(@Param('id') id:number): void {
        const deleted =  this.productsService.remove(id);
        if (!deleted) {
            throw new NotFoundException(`Product #${id} not found`);
        }
    }
}

