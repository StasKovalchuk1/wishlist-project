package wishlist;

import lombok.Data;

import javax.persistence.Embeddable;
import java.io.Serializable;

@Embeddable
@Data
public class UserWishMappingId implements Serializable {
    private int userId;
    private int wishId;
}
