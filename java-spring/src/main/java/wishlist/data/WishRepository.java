package wishlist.data;

import org.springframework.data.repository.CrudRepository;
import wishlist.Wish;

public interface WishRepository extends CrudRepository<Wish, Integer> {
}
