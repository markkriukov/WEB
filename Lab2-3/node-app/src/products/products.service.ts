import { Injectable } from '@nestjs/common';
import {InjectRepository} from "@nestjs/typeorm";
import {Product} from "./products.entity";
import {DeleteResult, Repository} from "typeorm";
import {IPaginationOptions, paginate, Pagination} from "nestjs-typeorm-paginate";

@Injectable()
export class ProductsService {
    constructor(
        @InjectRepository(Product)
        private repository: Repository<Product>,
    ) {}

    public create(productData: Product): Promise<Product> {
        return this.repository.save(productData);
    }

    async findAll(): Promise<Product[]> {
        return await this.repository.find({ relations: ['category'] });
    }

    public findOne(id: number): Promise<Product | null> {
        return this.repository.findOneBy({ id });
    }

    public  remove(id: number): Promise<DeleteResult>{
        return this.repository.delete(id);
    }
    public paginate(options: IPaginationOptions): Promise<Pagination<Product>> {
        return paginate<Product>(this.repository, options);
    }
}

