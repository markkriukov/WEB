import { Injectable } from '@nestjs/common';
import {InjectRepository} from "@nestjs/typeorm";
import {Category} from "./category.entity";
import {DeleteResult, Repository} from "typeorm";
import {IPaginationOptions, paginate, Pagination} from "nestjs-typeorm-paginate";

@Injectable()
export class CategoriesService {
    constructor(
        @InjectRepository(Category)
        private repository: Repository<Category>,
    ) {}

    private readonly categories: Omit<Category, 'id'>[] = [
        {
            name: 'Fruits',
            description: 'All kinds of fruits',
            products: [],
        },
        {
            name: 'Vegetables',
            description: 'Various types of vegetables',
            products: [],
        },
    ];

    public create(categoryData: Category): Promise<Category> {
        return this.repository.save(categoryData);
    }

    public findAll(): Promise<Category[]> {
        return this.repository.find();
    }

    public findOne(id: number): Promise<Category | null> {
        return this.repository.findOneBy({ id });
    }

    //public  remove(id: number): Promise<DeleteResult>{
    //    return this.repository.delete(id);
    //}

    public async remove(id: number): Promise<void> {
        await this.repository.delete(id);
    }    
    
    public paginate(options: IPaginationOptions): Promise<Pagination<Category>> {
        return paginate<Category>(this.repository, options);
    }

    async createCategories() {
        for (const category of this.categories) {
            const existingCategory = await this.repository.findOne({ where: { name: category.name } });
            if (!existingCategory) {
                const newCategory = this.repository.create(category);
                await this.repository.save(newCategory);
            }
        }
    }
}
