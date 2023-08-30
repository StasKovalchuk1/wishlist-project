package wishlist;

import lombok.Data;

import javax.persistence.*;

@Entity
@Data
public class UserWishMapping {

    @EmbeddedId
    private UserWishMappingId id;

    @ManyToOne
    @MapsId("userId")
    @JoinColumn(name = "user", referencedColumnName = "id")
    private User user;

    @ManyToOne(fetch = FetchType.LAZY)
    @MapsId("wishId")
    @JoinColumn(name = "wish", referencedColumnName = "id")
    private Wish wish;

    public UserWishMapping(User user, Wish wish) {
        this.user = user;
        this.wish = wish;
    }

    public UserWishMapping() {}

}
