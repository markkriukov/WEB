import { Category } from "../categories/category.entity";
import {Column, CreateDateColumn, Entity, ManyToOne, PrimaryGeneratedColumn, UpdateDateColumn} from "typeorm";

@Entity("products")
export class Product {
    @PrimaryGeneratedColumn()
    id: number;
    @Column()
    name: string;
    @Column("float")
    price: number;
    @ManyToOne(() => Category, category => category.products, {eager: true})
    category: Category;    
}
